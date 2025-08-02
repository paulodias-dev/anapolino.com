<?php

namespace App\Http\Controllers\Api;

use App\Models\Core\Category;
use App\Http\Controllers\Api\BaseController;

class CategoryController extends BaseController
{
    public function index()
    {
        $categories = Category::with('subcategories')
            ->active()
            ->ordered()
            ->get();

        return $this->successResponse($categories);
    }

    public function withListings()
    {
        $categories = Category::with(['subcategories.listings' => function($query) {
            $query->active()->latest()->limit(4);
        }])->active()->ordered()->get();

        return $this->successResponse($categories);
    }
}
