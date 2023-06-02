<?php

namespace App\Http\Controllers;

use App\Models\SocialMediaPlatform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialMediaPlatformController extends Controller
{
    public function createForm(){
        if(empty(Auth::id())){
            return redirect()->route('login');
        }
        return view('SocialMediaPlatform/create');
    }

    public function createInstance(Request $request){
        $request->validate([
            'logo' => 'required|image|max:2048'
        ]);
        dump($request);
        dump($request->file('logo'));
        dump($request->get('name'));
        $fileName = time().'_'.$request->file('logo')->getClientOriginalName();
        dump(urlencode($fileName));
        $filePath = $request->file('logo')->storeAs('uploads/images/social-media-platform', urlencode($fileName), 'public');
        $social_media_platform = new SocialMediaPlatform();
        $social_media_platform->name = $request->get('name');
        $social_media_platform->logo = '/storage/' . $filePath;
        $social_media_platform->save();
        return back()
            ->with('success','Social saved.')
            ->with('icon', urlencode($fileName));
    }
}
