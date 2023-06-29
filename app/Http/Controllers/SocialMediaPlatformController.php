<?php

namespace App\Http\Controllers;

use App\Models\SocialMediaLink;
use App\Models\SocialMediaPlatform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SocialMediaPlatformController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function create()
    {
        return view('SocialMediaPlatform/create');
    }

    public function delete(int $social_id)
    {
        $social_media_platform = SocialMediaPlatform::query()->find($social_id);
        if (!empty($social_media_platform)) {
            SocialMediaPlatform::query()->where('social_media_platform', '=', $social_id)->delete();
            $this->removeLogo($social_id);
            $social_media_platform->delete();
            return redirect()->route('listSocialMediaPlatforms');
        }
        abort(404, "That platform doesn't exist.");
    }

    public function edit(int $social_id)
    {
        $social_media_platform = SocialMediaPlatform::query()
            ->where('id', '=', $social_id)
            ->first();
        if (empty($social_media_platform)) {
            return redirect()->route('dashboard');
        }
        $vars = [
            'existing_values' => [
                'name' => $social_media_platform->name,
                'logo' => !empty($social_media_platform->logo) ? url($social_media_platform->logo) : '',
            ],
            'social_id' => $social_id,
        ];
        return view('SocialMediaPlatform/edit', $vars);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|max:2048',
        ]);
        $fileName = time() . '_' . $request->file('logo')->getClientOriginalName();
        $filePath = $request->file('logo')
            ->storeAs('uploads/images/social-media-platform', urlencode($fileName), 'public');
        $social_media_platform = new SocialMediaPlatform();
        $social_media_platform->name = $request->get('name');
        $social_media_platform->logo = '/storage/' . $filePath;
        $social_media_platform->save();
        return back()
            ->with('success', 'Social Media Platform saved.');
    }

    public function removeLogo(int $social_id)
    {
        $social_media_platform = SocialMediaPlatform::query()->find($social_id);
        if (!empty($social_media_platform)) {
            if (!empty($social_media_platform->logo)) {
                File::delete(public_path() . $social_media_platform->logo);
                return response()->json($social_media_platform->update(['logo' => null]));
            }
        }
        abort(404, "That platform doesn't exist.");
    }

    public function update(Request $request, int $social_id)
    {
        $social = SocialMediaPlatform::query()->find($social_id);
        if (!empty($social)) {
            $vars = [
                'name' => $request->get('name'),
            ];
            if (!empty($request->file('logo'))) {
                $request->validate([
                    'logo' => 'required|image|max:2048'
                ]);
                $this->removeLogo($social_id);
                $fileName = time() . '_' . $request->file('logo')->getClientOriginalName();
                $filePath = $request->file('logo')->storeAs('uploads/images/social-media-platform', urlencode($fileName), 'public');
                $vars['logo'] = '/storage/' . $filePath;
            }
            $social->update($vars);
            return redirect()->route('listSocialMediaPlatforms');
        }
        abort(404, "That platform doesn't exist.");
    }

    public function list()
    {
        $social_media_platforms = SocialMediaPlatform::all(['id', 'name', 'logo']);
        $user_links = SocialMediaLink::query()->where('user', '=', Auth::id())->pluck('id')->toArray();
        $vars = [
            'social_media_platforms' => $social_media_platforms,
            'user_links' => $user_links,
        ];
        return view('SocialMediaPlatform/list', $vars);
    }
}
