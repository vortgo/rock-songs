<?php

namespace App\Console\Commands;

use App\Models\Radio;
use App\Models\Song;
use Illuminate\Console\Command;

class RadioParse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'radio:parse';

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
        $data = file_get_contents('http://www.heavy-music.net/songTitle.php');
        $onAir = str_replace(['Now: ', '</body></html>'], '', $data);

        $last = Radio::orderByDesc('id')->first();

        if ($last && $last->on_air == $onAir) {
            $this->info("On Air: {$onAir}");
            return;
        }

        $radio = new Radio();
        $radio->on_air = $onAir;

        $delimiterPos = strpos($onAir, '-');
        $band = trim(substr($onAir, 0, $delimiterPos));
        $songName = trim(substr($onAir, $delimiterPos + 1, strlen($onAir)));

        $song = Song::where('name', $songName)->whereHas('album.band', function ($q) use ($band) {
            $q->where('name', $band);
        })->first();

        if ($song) {
            $radio->song_id = $song->id;
        }
        $radio->save();
        $founded = (bool)$song;

        $this->info("On Air: {$onAir}; band: {$band}; song: {$songName}; founded: {$founded}}");
    }
}
