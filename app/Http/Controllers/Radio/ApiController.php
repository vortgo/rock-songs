<?php
/**
 * Created by PhpStorm.
 * User: vortgo
 * Date: 07.02.19
 * Time: 21:54
 */

namespace App\Http\Controllers\Radio;


use App\Http\Controllers\Controller;
use App\Models\Radio;

class ApiController extends Controller
{
    public function history()
    {
        $history = Radio::orderByDesc('id')->limit(10)->get();

        $response = [];

        foreach ($history as $song) {
            $response[] = [
                'title' => $song->on_air,
                'time'  => $song->created_at->format('Y-m-d H:i:s'),
                'url'   => $song->song ? $this->makeUrl($song->song->download_url) : null
            ];
        }

        return response()->json($response);
    }

    private function makeUrl($link)
    {
        $result = [];
        parse_str($link, $result);
        $result = array_values($result);
        return str_replace(' ', '%20', "http://dl.heavy-music.ru:81/{$result[0]}/$result[1]/$result[2]");
    }
}
