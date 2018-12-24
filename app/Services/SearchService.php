<?php
/**
 * Created by PhpStorm.
 * User: vortgo
 * Date: 23.12.18
 * Time: 15:00
 */

namespace App\Services;


use App\Models\Song;

class SearchService
{
    public function search($text)
    {
        Song::with('album')->where('name', 'LIKE', "%$text%")->limit(10);
    }
}