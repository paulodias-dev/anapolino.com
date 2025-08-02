<?php

namespace App\Http\Controllers\Api;

use App\Models\Core\PortalSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PortalSettingController extends BaseController
{
    public function show()
    {
        $settings = PortalSetting::getSettings();
        return $this->successResponse($settings);
    }

    public function update(Request $request)
    {
        // Apenas administradores podem atualizar
        if (!$request->user()->isAdmin()) {
            return $this->errorResponse('Acesso não autorizado', 403);
        }

        $validator = Validator::make($request->all(), [
            'site_title' => 'sometimes|string|max:255',
            'site_description' => 'nullable|string',
            'domain' => 'sometimes|string|max:255',
            'default_language' => 'sometimes|string|max:10',
            'supported_languages' => 'sometimes|array',
            'contact_email' => 'sometimes|email',
            'contact_phone' => 'sometimes|string|max:20',
            'address' => 'sometimes|string',
            'city' => 'sometimes|string',
            'state' => 'sometimes|string|max:2',
            'zip_code' => 'sometimes|string|max:10',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:512',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        $settings = PortalSetting::getSettings();
        $data = $request->except(['logo', 'favicon']);

        // Upload do logo
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('portal', 'public');
            if ($settings->logo_path) {
                Storage::disk('public')->delete($settings->logo_path);
            }
            $data['logo_path'] = $path;
        }

        // Upload do favicon
        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('portal', 'public');
            if ($settings->favicon_path) {
                Storage::disk('public')->delete($settings->favicon_path);
            }
            $data['favicon_path'] = $path;
        }

        $settings->update($data);

        return $this->successResponse($settings, 'Configurações atualizadas com sucesso');
    }
}
