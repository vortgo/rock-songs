<?php

namespace App\Console\Commands;

use App\Models\Song;
use Illuminate\Console\Command;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

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
     * @return mixed
     */
    public function handle()
    {
//        $count = Song::count();
//        $bar = $this->output->createProgressBar($count);
//
//        Song::chunk(1000, function($songs) use($bar){
//            $songs->addToIndex();
//            $bar->advance(1000);
//        });
//
//        $bar->finish();

    }
}
