<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cartlow:categories';

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

            $this->saveCategory($category, $categories);

        }

        $this->saveCategories($categories);

        return 0;
    }

    protected function saveCategory($category, &$categories)
    {
        $this->line("> Checking category: {$category['name']}");
        if (null === collect($categories)->where('name', $category['name'])->first()) {

            $this->line("> Saving category: {$category['name']}");
            $categories[] = [
                'name' => $category['name'],
                'icon' => $category['icon'],
            ];
        }


        if (!isset($category['sub_category'])) {
            return;
        }

        foreach ($category['sub_category'] as $subCategory) {

            $this->line("");
            $this->line("> Checking Subcategories");
            $this->saveCategory($subCategory, $categories);
        }
    }

    protected function getCategories()
    {
        $categoriesResponse = $this->getCategoriesResponse();

        if (empty($categoriesResponse)) {
            return [];
        }

        return $categoriesResponse['category'] ? $categoriesResponse['category'] : [];
    }

    protected function getCategoriesResponse()
    {
        return json_decode(file_get_contents("https://api.cartlow.net/api/getCategories"), true);
    }

    protected function saveCategories($categories)
    {
        return file_put_contents(storage_path('app/catalog/categories.json'), json_encode($categories));
    }
}
