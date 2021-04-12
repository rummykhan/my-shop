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
        $imageUrl = 'https://cdn.vox-cdn.com/thumbor/D9XXOcVoGDtJCIJHpHbi_OKI5hY=/1400x1400/filters:format(jpeg)/cdn.vox-cdn.com/uploads/chorus_asset/file/9283449/jbareham_170916_2000_0057.jpg';
        $imageName = Str::random(32) . '.jpg';

        Storage::disk('categories')->put($imageName, file_get_contents($imageUrl));

        return [
            'name' => 'Mobiles',
            'image' => $imageName,
        ];
    }
}
