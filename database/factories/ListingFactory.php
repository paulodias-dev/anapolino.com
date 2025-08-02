<?php

namespace Database\Factories;

use App\Models\Core\Listing;
use App\Models\User;
use App\Models\Core\Category;
use App\Models\Core\Subcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ListingFactory extends Factory
{
    protected $model = Listing::class;

    public function definition()
    {
        $category = Category::inRandomOrder()->first();
        $subcategory = $category && $category->subcategories()->exists()
            ? $category->subcategories()->inRandomOrder()->first()
            : null;

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'category_id' => $category ? $category->id : null,
            'subcategory_id' => $subcategory ? $subcategory->id : null,
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph,
            'phone' => $this->faker->phoneNumber,
            'whatsapp' => $this->faker->boolean,
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->stateAbbr,
            'zip_code' => $this->faker->postcode,
            'delivery_available' => $this->faker->boolean,
            'website' => $this->faker->url,
            'active' => $this->faker->boolean,
        ];
    }
}
