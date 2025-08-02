<?php

namespace App\Http\Controllers\Api;

use App\Models\Core\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;

class UserController extends BaseController
{
    public function show(Request $request)
    {
        return $this->successResponse($request->user()->load('listings'));
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20',
            'password' => 'sometimes|string|min:8|confirmed'
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return $this->successResponse($user, 'Perfil atualizado com sucesso');
    }
}
