<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SocialMediaPlatformController extends Controller
{
    public function createForm(){
        return view('SocialMediaPlatform/create');
    }
}
