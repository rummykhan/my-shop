<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class UploadImagesToS3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'catalog:upload-images';

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
        $this->line("> Reading JSON.");
        $catalogJson = json_decode(file_get_contents(storage_path('app/catalog/catalog.json')), true);

        $this->line("> Getting uploaded files.");
        $uploaded = $this->getUploadedFiles();

        $i = 0;
        $this->line("> Starting iteration.");
        //$progressBar = $this->getOutput()->createProgressBar(count($catalogJson));
        foreach ($catalogJson as $index => $item) {

            if (isset($uploaded[$item['image']])) {
                $this->line("> [{$index}]: Image found in uploads: {$item['image']}");
                //$progressBar->advance(1);
                continue;
            }

            try {
                $this->line("> [{$index}]: Uploading image: {$item['image']}");

                if ($this->uploadImage($item['image'], $item['image_url'])) {
                    $uploaded[$item['image']] = $item['image'];
                }

            } catch (Exception $exception) {

                $this->line("> [{$index}] Error: " . $exception->getMessage());

                $uploaded[$item['image']] = $item['image'];
                continue;
            }

            //$progressBar->advance(1);


            $i++;

            if ($i === 10) {
                $this->saveUploadedFiles($uploaded);
                $i = 0;
            }
        }


        $this->saveUploadedFiles($uploaded);
        //$progressBar->finish();

        $this->line("");
        $this->line("Done √");
    }

    protected function uploadImage($name, $url)
    {
        return Storage::disk('s3')->put($name, file_get_contents($url));
    }

    protected function saveUploadedFiles($files)
    {
        $data = ['files' => array_values($files)];

        file_put_contents(storage_path('app/catalog/uploaded.json'), json_encode($data));
    }

    protected function getUploadedFiles()
    {
        $uploaded = $this->readUploaded();

        return isset($uploaded['files']) ? array_combine($uploaded['files'], $uploaded['files']) : [];
    }

    protected function readUploaded()
    {
        return json_decode(file_get_contents(storage_path('app/catalog/uploaded.json')), true);
    }
}
