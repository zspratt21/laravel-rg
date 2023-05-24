<?php

namespace App\Http\Controllers;

use App\Models\SocialMediaPlatform;
use Illuminate\Http\Request;

class SocialMediaPlatformController extends Controller
{
    public function createForm(){
        return view('SocialMediaPlatform/create');
    }

    public function createInstance(Request $request){
        $request->validate([
            'logo' => 'required|mimes:png,jpg,svg,jpeg,webp|max:2048'
        ]);
        dump($request);
        dump($request->file('logo'));
        dump($request->get('name'));
        $fileName = time().'_'.$request->file('logo')->getClientOriginalName();
        dump($fileName);
        $filePath = $request->file('logo')->storeAs('uploads/images/social-media-platform', $fileName, 'public');
        $social_media_platform = new SocialMediaPlatform();
        $social_media_platform->name = $request->get('name');
        $social_media_platform->logo = '/storage/' . $filePath;
        $social_media_platform->save();
        return back()
            ->with('success','Social saved.')
            ->with('icon', $fileName);
    }
}
