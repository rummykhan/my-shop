<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use SimpleXMLElement;

class Extract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'extract:xml-to-json';

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
        $xmlCatalog = simplexml_load_string(file_get_contents(storage_path('app/catalog/catalog.xml')));

        $progressBar = $this->getOutput()->createProgressBar(count($xmlCatalog->entry));

        $i = 0;
        $data = [];
        /** @var SimpleXMLElement $entry */
        foreach ($xmlCatalog->entry as $entry) {

            $data[] = $this->xmlToData($entry);

            if (false && $i > 10) {
                break;
            }

            $i++;
            $progressBar->advance();
        }

        $progressBar->finish();

        file_put_contents(storage_path('app/catalog/catalog.json'), json_encode($data));

        $this->line("\r\n");
        $this->line("> app/catalog/catalog.json created");
    }

    /**
     * @param SimpleXMLElement $entry
     * @return array
     */
    protected function xmlToData($entry)
    {
        $imageUrl = (string)strtolower($entry->image_link);
        $imageName = null;
        if (!empty($imageUrl)) {
            $imageName = Str::random(32) . '.' . $this->getImageExtension($imageUrl);
        }


        return [
            'title' => html_entity_decode((string)$entry->title),
            'description' => html_entity_decode((string)$entry->description),
            'brand' => (string)$entry->brand,
            'inventory' => (int)$entry->inventory,
            'image' => $imageName,
            'image_url' => (string)strtolower($entry->image_link),
            'price' => floatval((string)$entry->price),
            'discounted_price' => floatval((string)$entry->sale_price),

            'google_product_category' => (int)$entry->google_product_category,
            'product_type' => html_entity_decode((string)$entry->product_type),
        ];
    }

    protected function getImageExtension($url)
    {
        if (empty($url)) {
            return null;
        }

        return strtolower(array_reverse(explode('.', basename($url)))[0]);
    }
}
