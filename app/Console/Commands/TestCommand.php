<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RummyKhan\TestPackage\HelloWorld;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:test';

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
        $obj = new HelloWorld();
        $obj->sayHello();
    }
}
