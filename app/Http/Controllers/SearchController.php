<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchPage(Request $request)
    {
        if ($request->has('search')) {
            $text = $request->get('search');
            $songsIds = Song::searchByQuery([
                "bool" => [
                    "should" => [
                        [
                            "multi_match" => [
                                "query"  => $text,
                                "fields" => [
                                    "song^1.8",
                                    "band^1.5",
                                    "album",
                                ]
                            ]
                        ]
                    ]
                ]
            ], null, null, 20)->pluck('id')->toArray();
            $songs = Song::with('album.band')->whereIn('id', $songsIds)->get();
            $songs = $songs->sortBy(function ($model) use ($songsIds) {
                return array_search($model->getKey(), $songsIds);
            });
            return view('search.index', compact('songs', 'text'));
        }
        return view('search.index');
    }
}
