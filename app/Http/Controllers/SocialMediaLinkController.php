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
    public function create()
    {
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

    public function delete($social_id)
    {
        $link = SocialMediaLink::query()
            ->where('social_media_platform', '=', $social_id)
            ->where('user', '=', Auth::id())
            ->first();
        if (!empty($link)) {
            $link->delete();
            return back();
        }
        // @todo correct error message
        return null;
    }

    // @todo
    public function edit() {}

    public function store(Request $request)
    {
        $platform = $request->get('social_media_platform');
        $link = SocialMediaLink::query()
            ->where('social_media_platform', '=', $platform)
            ->where('user', '=', Auth::id())
            ->first();
        if (empty($link)) {
            $social_link = new SocialMediaLink();
            $social_link->url = $request->get('url');
            $social_link->social_media_platform = $platform;
            $social_link->user = Auth::id();
            $social_link->save();
            return back()
                ->with('success', 'Social link saved.');
        }
        // @todo error: link already exists for this user!
        return null;
    }
}
