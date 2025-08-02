<?php

namespace Database\Factories\Core;

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
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'category_id' => $category ? $category->id : Category::factory(),
            'subcategory_id' => $subcategory ? $subcategory->id : null,
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph,
            'phone' => $this->faker->phoneNumber,
            'whatsapp' => $this->faker->boolean,
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->stateAbbr,
            'zip_code' => $this->faker->postcode,
            'latitude' => $this->faker->latitude(-16.8, -16.2),
            'longitude' => $this->faker->longitude(-49.2, -48.8),
            'delivery_available' => $this->faker->boolean,
            'website' => $this->faker->optional(0.7)->url,
            'active' => true,
            'featured' => $this->faker->boolean(20),
            'featured_until' => $this->faker->optional(0.2, null)->dateTimeBetween('now', '+30 days'),
        ];
    }
}
