<?php

namespace Database\Seeders;

use App\Models\Item;
use Database\Factories\ItemFactory;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $total = 50;

        $output = $this->command->getOutput();

        $progressBar = $output->createProgressBar($total);

        Item::factory($total)
            ->afterCreating(function ($item) use ($progressBar) {

                $progressBar->advance(1);

            })
            ->create();

        $progressBar->finish();
        $this->command->line("");
    }
}
