<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadCategoryPhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'categories:image-upload';

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
        $categoriesJson = $this->getCategories();

        $categories = [];

        foreach ($categoriesJson as $category) {

            $this->line("> Update category image: {$category['name']}");

            $categories = $this->updateCategoryImage($category, $categories);
        }

        $this->saveCategories($categories);
    }

    protected function updateCategoryImage($category, $categories)
    {
        $category['image'] = $this->uploadImage($category);

        if (!isset($category['sub_category'])) {

            $categories[] = $category;

            return $categories;
        }

        $subCategories = [];
        foreach ($category['sub_category'] as $subCategory) {
            $subCategories = $this->updateCategoryImage($subCategory, $subCategories);
        }

        $category['sub_category'] = $subCategories;
        $categories[] = $category;

        return $categories;
    }

    public function uploadImage($category)
    {
        $s3Url = 'https://s2smyshop.s3.ap-south-1.amazonaws.com';

        $name = Str::random(32) . '.' . strtolower($this->getExtension($category['icon']));

        $this->line("Uploading to S3");

        try {
            Storage::disk('s3')->put($name, file_get_contents($category['icon']));
        } catch (\Exception $exception) {
            $this->error("ex: " . $exception->getMessage());
        }

        return $s3Url . '/' . $name;
    }

    protected function getExtension($image)
    {
        return array_reverse(explode('.', basename($image)))[0];
    }

    protected function getCategories()
    {
        $categoriesResponse = $this->getCategoriesResponse();

        if (empty($categoriesResponse)) {
            return [];
        }

        return $categoriesResponse;
    }

    protected function getCategoriesResponse()
    {
        return json_decode(file_get_contents(storage_path("app/catalog/categories.json")), true);
    }

    protected function saveCategories($categories)
    {
        return file_put_contents(storage_path('app/catalog/categories.json'), json_encode($categories));
    }
}
