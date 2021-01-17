<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = 'laptop ' . $this->faker->word();
        $image = $this->faker->imageUrl();
        $description = $this->faker->paragraph();
        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'featured_image' => $image,
            'details' => [13,14,15][array_rand([13,14,15])] . ' inch, ' . [1, 2, 3][array_rand([1, 2, 3])] .' TB SSD, 32GB RAM',
            'description' => $description,
            'price' => rand(149999, 249999),
        ];
    }
}
