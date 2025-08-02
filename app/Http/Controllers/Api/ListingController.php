<?php

namespace App\Http\Controllers\Api;

use App\Models\Core\Listing;
use App\Models\Core\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Validator;

class ListingController extends BaseController
{
    public function index(Request $request)
    {
        $query = Listing::with(['category', 'subcategory', 'user', 'mainImage'])
            ->active()
            ->latest();

        // Filtros
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('description', 'like', '%'.$request->search.'%');
        }

        $listings = $query->paginate(10);

        return $this->successResponse($listings);
    }

    public function show($id)
    {
        $listing = Listing::with([
            'category',
            'subcategory',
            'user',
            'images',
            'businessHours'
        ])->active()->findOrFail($id);

        return $this->successResponse($listing);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'business_hours' => 'required|array'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        $listing = $request->user()->listings()->create($request->all());

        // Upload de imagens
        foreach ($request->file('images') as $key => $image) {
            $path = $image->store('listings', 'public');
            $listing->images()->create([
                'path' => $path,
                'is_main' => $key === 0
            ]);
        }

        // Horários de funcionamento
        foreach ($request->business_hours as $day => $hours) {
            $listing->businessHours()->create([
                'day' => $day,
                'open_time' => $hours['open'] ?? null,
                'close_time' => $hours['close'] ?? null,
                'closed' => $hours['closed'] ?? false
            ]);
        }

        return $this->successResponse($listing, 'Anúncio criado com sucesso', 201);
    }

    public function update(Request $request, Listing $listing)
    {
        $this->authorize('update', $listing);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'category_id' => 'sometimes|exists:categories,id',
            'subcategory_id' => 'sometimes|exists:subcategories,id',
            'phone' => 'sometimes|string|max:20',
            'address' => 'sometimes|string',
            'images' => 'sometimes|array',
            'images.*' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
            'business_hours' => 'sometimes|array'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        $listing->update($request->all());

        // Lógica para atualizar imagens e horários...

        return $this->successResponse($listing, 'Anúncio atualizado com sucesso');
    }

    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);

        $listing->delete();
        return $this->successResponse(null, 'Anúncio removido com sucesso');
    }
}
