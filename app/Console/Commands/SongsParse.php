<?php

namespace App\Console\Commands;

use App\Models\Album;
use App\Models\Band;
use App\Models\Song;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;


class SongsParse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'songs:parse';

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
//        $this->parseAlbums();
//        $this->parseBands();
//        $this->parseTracks();
    }

    public function parseTracks()
    {
        Album::with('band')->where('id', '>', 5316)->chunk(200, function ($albums) {
            /** @var Album $album */
            foreach ($albums as $album) {
                $ctx = stream_context_create(array('http' =>
                                                       array(
                                                           'timeout' => 15,  //1200 Seconds is 20 Minutes
                                                       )
                ));

                $band = $album->band;
                $year = $album->year ?? 'None';
                $url = str_replace(' ', '%20', "http://www.heavy-music.ru/?browse&band=$band->name&album=($year)%20-%20$album->name");
                $crawler = new Crawler(file_get_contents($url, false, $ctx));
                $songsNumbersSections = $crawler->filter('#jp_container')->first()->filter('tr');

                $songsToInsert = [];
                foreach ($songsNumbersSections as $numberSection) {
                    $numberSection = new Crawler($numberSection);

                    if (!$numberSection->filter('.live_button_caption')->count()) {
                        continue;
                    }

                    $songNumber = trim(str_replace('.', '', $numberSection->filter('.live_button_caption')->text()));
                    $songSection = new Crawler($numberSection->filter('.live_button_caption')->getNode(0)->parentNode);
                    $a = $songSection->filter('a');
                    $songName = $a->text();
                    $songSize = str_replace(['(', ')'], '', $songSection->filter('span')->filter('.album_punkt')->text());

                    $secondSongsSection = $numberSection->filter('td')->eq(1);
                    $songDuration = trim(str_replace(' <a', '', explode(" ", $secondSongsSection->html())[0]));
                    $songUrl = $secondSongsSection->filter('a')->attr('href');


                    $songsToInsert[] = [
                        'name'         => $songName,
                        'album_id'     => $album->id,
                        'download_url' => $songUrl,
                        'number'       => $songNumber,
                        'size'         => $songSize,
                        'duration'     => $songDuration,
                    ];

                }
                Song::insert($songsToInsert);
                $count = count($songsToInsert);
                $this->output->text("$band->name - $album->name processed; Parsed songs - $count");
            }
        });


    }

    public function parseBands()
    {
        $disk = \Storage::disk('music_ftp');
        $bands = collect($disk->directories());

        $bar = $this->output->createProgressBar($bands->count());

        foreach ($bands->chunk(500) as $bandsChunk) {

            $insertPrepare = [];
            foreach ($bandsChunk as $band) {
                $insertPrepare[] = ['name' => $band];
            }
            Band::insert($insertPrepare);

            $bar->advance(500);
        }

    }

    public function parseAlbums()
    {
        $url = 'http://www.heavy-music.ru/?browse&band=';
        Band::where('id', '>', 919)->chunk(100, function ($bands) use ($url) {
//
            /** @var Band $band */
            foreach ($bands as $band) {
                $html = file_get_contents(str_replace(' ', '%20', $url . $band->name));

                $crawler = new Crawler($html);
                $albums = $crawler->filter('.perflisting_album_name');

                $bandsAlbums = [];
                foreach ($albums as $album) {
                    $link = new Crawler($album);
                    $imgElem = $link->filter('img');

                    if (!$imgElem->count()) {
                        continue;
                    }

                    $imageUrl = $imgElem->attr('src');
                    $title = $link->filter('[id=title]')->text();
                    $yearText = $link->filter('[id=artist]')->text();
                    preg_match('#\((.*?)\)#', $yearText, $match);
                    $year = $match[1] ?? null;

                    $bandsAlbums[] = [
                        'name'    => $title,
                        'year'    => is_numeric($year) ? $year : null,
                        'cover'   => $imageUrl,
                        'band_id' => $band->id,
                    ];
                }

                Album::insert($bandsAlbums);
                $count = count($bandsAlbums);
                $this->output->text("$band->name - processed; Parsed albums - $count");
            }
        });
    }
}




