<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $imageUrl = $this->getImageUrl();
        $imageName = Str::random(32) . '.png';
        $itemTitle = 'iPhone - ' . $this->faker->name;

        print("Making item: {$itemTitle} \r\n");
        print(" Downloading & Saving image: {$imageUrl}\r\n");

        Storage::disk('items')->put($imageName, file_get_contents($imageUrl));

        $category = Category::first();

        return [
            'title' => $itemTitle,
            'price' => rand(800, 1000),
            'image' => $imageName,
            'category_id' => $category ? $category->id : null,
        ];
    }

    protected function getImageUrl()
    {
        $urls = $this->getUrls();

        return $urls[rand(0, (count($urls) - 1))];
    }

    protected function getUrls()
    {
        return [
            'https://specials-images.forbesimg.com/imageserve/5f766465171081b47b0e73ad/960x0.jpg',
            'https://drop.ndtv.com/TECH/product_database/images/913201720152AM_635_iphone_x.jpeg',
            'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone11-red-select-2019?wid=940&hei=1112&fmt=png-alpha&qlt=80&.v=1566956144763',
            'https://fdn2.gsmarena.com/vv/pics/apple/apple-iphone-12-pro-max-1.jpg',
            'https://cdn.mos.cms.futurecdn.net/4fxJtRFSxRMGs6yUsjhrkS-1200-80.jpg',
        ];
    }
}
