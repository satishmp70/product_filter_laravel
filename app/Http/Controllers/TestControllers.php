<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestControllers extends Controller
{
    public function show() {
        $feed = \Dymantic\InstagramFeed\Profile::where('username', 'michael')->first()->feed();
    
        return view('welcome', ['instagram' => $feed]);
    }
}
