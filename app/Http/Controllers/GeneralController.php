<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function policy(Request $request)
    {
        return view('general.policy');
    }
}
