<?php

namespace App\Http\Controllers;

use App\Models\SocialMediaLink;
use App\Models\SocialMediaPlatform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialMediaLinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function createForm()
    {
        if (empty(Auth::id())) {
            return redirect()->route('login');
        }
        $platforms = SocialMediaPlatform::all(['name', 'id']);
        $platform_options = [];
        foreach ($platforms as $platform) {
            $platform_options[$platform->id] = $platform->name;
        }
        $vars = [
            'platform_options' => $platform_options,
        ];
        return view('SocialMediaLink/create', $vars);
    }

    public function createInstance(Request $request)
    {
        dump($request);
        dump($request->get('url'));
        dump($request->get('social_media_platform'));
        dump(Auth::id());
        $social_link = new SocialMediaLink();
        $social_link->url = $request->get('url');
        $social_link->social_media_platform = $request->get('social_media_platform');
        $social_link->user = Auth::id();
        $social_link->save();
        return back()
            ->with('success', 'Social link saved.');
    }
}
