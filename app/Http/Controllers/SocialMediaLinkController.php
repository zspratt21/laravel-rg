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
        $link = Auth::user()->socialLinks()->where('social_media_platform_id', '=', $social_id);
        if (!empty($link)) {
            $link->delete();
            return back();
        }
        abort(404, 'Either that link does not exist or is not associated with your account');
    }

    public function store(Request $request)
    {
        $platform = $request->get('social_media_platform');
        $link = Auth::user()->socialLinks()->where('social_media_platform_id', '=', $platform);
        if (!$link->exists()) {
            $social_link = new SocialMediaLink();
            $social_link->url = $request->get('url');
            $social_link->social_media_platform_id = $platform;
            $social_link->user_id = Auth::id();
            $social_link->save();
            return back()
                ->with('success', 'Social link saved.');
        }
        abort(500, 'Link already exists for this user.');
    }
}
