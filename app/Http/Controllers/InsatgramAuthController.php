<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InsatgramAuthController extends Controller
{
    public function show() {
        $profile = \Dymantic\InstagramFeed\Profile::where('username', 'michael')->first();
    
        return view('instagram-auth-page', ['instagram_auth_url' => $profile->getInstagramAuthUrl()]);
    }
    
    public function complete() {
        $was_successful = request('result') === 'success';
    
        return view('instagram-auth-response-page', ['was_successful' => $was_successful]);
    }
}
