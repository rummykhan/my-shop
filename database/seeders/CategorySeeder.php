<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->houseKeeping();

        // Category::factory(1)->create();

        $this->seedRealData();

    }

    protected function seedRealData()
    {
        $data = $this->getCategorySeedData();

        $progressBar = $this->command->getOutput()->createProgressBar();

        foreach ($data as $datum) {
            $this->createCategory($datum);

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->line("");
    }

    protected function createCategory($data)
    {
        $model = Category::where('name', $data['name'])->first();

        if ($model) {
            return;
        }

        $model = new Category();
        $model->id = $data['id'];
        $model->name = $data['name'];
        $model->image = Str::random(32) . '.jpg';

        Storage::disk('categories')->put($model->image, file_get_contents($data['image_url']));

        $model->save();
    }

    protected function getCategorySeedData()
    {
        return [
            [
                'id' => '267',
                'name' => 'Mobiles',
                'image_url' => 'https://cdn.vox-cdn.com/thumbor/D9XXOcVoGDtJCIJHpHbi_OKI5hY=/1400x1400/filters:format(jpeg)/cdn.vox-cdn.com/uploads/chorus_asset/file/9283449/jbareham_170916_2000_0057.jpg',
            ],
            [
                'id' => '404',
                'name' => 'Television',
                'image_url' => 'https://images.samsung.com/is/image/samsung/pk-hdtv-n5300-global-ua49n5300arxmm-frontblack-115424465?$720_720_PNG$',
            ],
            [
                'id' => '328',
                'name' => 'Laptop',
                'image_url' => 'https://www.lifewire.com/thmb/eSW9OWLYN2Hpw_m58Nu9oXAUljo=/1500x1500/filters:no_upscale()/Macbook-Air_HeroSquare-b01f607ff65345dcbe5b74a357f1a76b.jpg',
            ]
        ];
    }

    public function houseKeeping()
    {
        $this->command->warn('Seeding: Removing old category image files');

        $files = Storage::disk('categories')->files();

        foreach ($files as $file) {
            Storage::disk('categories')->delete($file);
        }
    }
}
