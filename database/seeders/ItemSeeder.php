<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleXMLElement;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->houseKeeping();

        $this->seedRealData();

        // $this->seedFakeData();
    }

    protected function seedRealData()
    {
        // 267 => Mobiles
        // 404 => Television
        // 328 => Laptop
        // 201 => Watches
        // 592 => Fragrances

        $data = $this->getItemsData();

        $total = 100;
        $count = 0;

        $progressBar = $this->command->getOutput()->createProgressBar(100);

        foreach ($data as $datum) {
            try {
                $this->saveEntry($datum);
            } catch (Exception $exception) {
                continue;
            }

            $progressBar->advance();

            if ($count >= $total) {
                break;
            }
        }

        $progressBar->finish();
    }

    protected function getItemsData()
    {
        $xmlCatalog = simplexml_load_string(file_get_contents(storage_path('app/catalog/catalog.xml')));

        $data = [];
        /** @var SimpleXMLElement $entry */
        foreach ($xmlCatalog->entry as $entry) {

            if (!in_array((string)$entry->google_product_category, [
                267,
                404,
                328
            ])) {
                continue;
            }

            $data[] = $this->makeEntry($entry);
        }

        return $data;
    }

    /**
     * @param SimpleXMLElement $entry
     * @return array
     */
    protected function makeEntry($entry)
    {
        $title = (string)$entry->title;
        $imageUrl = (string)strtolower($entry->image_link);
        $price = (string)$entry->price;
        $imageName = null;
        $category = Category::where('id', (string)$entry->google_product_category)->first();


        if (!empty($imageUrl)) {
            $imageName = Str::random(32) . '.' . $this->getImageExtension($imageUrl);
        }

        return [
            'title' => $title,
            'image' => $imageName,
            'image_url' => $imageUrl,
            'price' => floatval($price),
            'category_id' => $category ? $category->id : null,
        ];
    }

    /**
     * @param array $data
     */
    protected function saveEntry($data)
    {
        if (!empty($data['image_url'])) {
            Storage::disk('items')->put($data['image'], file_get_contents($data['image_url']));
        }

        $model = new Item(Arr::except($data, ['image_url']));
        $model->save();

    }

    protected function getImageExtension($url)
    {
        if (empty($url)) {
            return null;
        }

        return strtolower(array_reverse(explode('.', basename($url)))[0]);
    }

    protected function fakeData()
    {
        $totalItems = 10;

        $progressBar = $this->command->getOutput()->createProgressBar($totalItems);

        Item::factory(3)
            ->afterMaking(function (Item &$item) use ($progressBar) {

                Storage::disk('items')->put($item->image, file_get_contents($item->image_url));

                unset($item->image_url);

                $progressBar->advance(1);
            })
            ->create();

        $progressBar->finish();
        $this->command->line("");
    }

    public function houseKeeping()
    {
        $this->command->info('Removing old items image files');

        $files = Storage::disk('items')->files();

        foreach ($files as $file) {
            Storage::disk('items')->delete($file);
        }
    }
}
