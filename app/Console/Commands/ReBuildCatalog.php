<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ReBuildCatalog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rebuild:catalog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $s3Url = 'https://s2smyshop.s3.ap-south-1.amazonaws.com';

        $this->line("> Reading JSON.");
        $catalogJson = json_decode(file_get_contents(storage_path('app/catalog/catalog.json')), true);

        $progressBar = $this->getOutput()->createProgressBar(count($catalogJson));

        $newCatalog = [];
        foreach ($catalogJson as $index => $item) {

            $itemPrice = $item['price'];

            if ($itemPrice <= 0) {
                continue;
            }

            if ($itemPrice > 500) {
                $itemPrice = intval($itemPrice / 3.65);
            }

            $newCatalog[] = [
                'title' => $this->cleanTitle($item['title']),
                'description' => $this->cleanDescription($item['description']),
                'brand' => strpos(strtolower($item['brand']), 'cartlow') !== false ? '' : $item['brand'],
                'inventory' => $item['inventory'],
                'image' => $s3Url . '/' . $item['image'],
                'price' => $itemPrice,
                'google_product_category' => $item['google_product_category'],
                'google_product_type' => $item['product_type'],
                'category' => $this->getCategory($item['product_type'])
            ];

            $progressBar->advance();
        }

        $progressBar->finish();

        $this->line("");
        $this->line("> Writing file to app/catalog/items.json");

        file_put_contents(storage_path('/app/catalog/items.json'), json_encode($newCatalog));
    }

    public function getCategory($product_type)
    {
        if (empty($product_type) || empty(trim($product_type))) {
            return null;
        }

        $categories = array_reverse(explode('>', $product_type));

        if (count($categories) === 0) {
            return null;
        }

        return trim($categories[0]);
    }

    public function cleanTitle($title)
    {
        return $this->cleanCartLow($title);
    }

    public function cleanDescription($description)
    {
        return $this->cleanCartLow($description);
    }

    public function cleanCartLow($data)
    {
        $data = str_replace('Cartlow', 'Shop', $data);
        $data = str_replace('cartlow', 'Shop', $data);

        return $data;
    }
}

/**
 * {
 * "title":"Eleven Paris Cara is My EX Phone Case Compatible for iPhone 6",
 * "description":"Specificationsbrand: eleven parisdesign: cara is my excolor: dark pink with a touch of black",
 * "brand":"Cartlow",
 * "inventory":34,
 * "image":"fzsfiaHIfKiiKQ1xIlnoGBh0ic8gaoSB.jpeg",
 * "image_url":"https:\/\/cdn.cartlow.com\/cartlow\/media-v2\/items\/original\/1576476155_6.jpeg",
 * "price":59,
 * "discounted_price":2,
 * "google_product_category":2353,
 * "product_type":"CE > Wireless > Mobiles Cases"
 * }
 */
