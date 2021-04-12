<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $imageUrl = 'https://fdn.gsmarena.com/imgroot/reviews/20/apple-iphone-12/lifestyle/-1200w5/gsmarena_021.jpg';
        $imageName = Str::random(32) . '.jpg';

        Storage::disk('items')->put($imageName, file_get_contents($imageUrl));

        return [
            'name' => 'Mobiles',
            'image' => $imageName,
        ];
    }
}
