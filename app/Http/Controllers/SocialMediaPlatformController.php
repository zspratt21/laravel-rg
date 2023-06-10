<?php

namespace App\Http\Controllers;

use App\Models\SocialMediaPlatform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SocialMediaPlatformController extends Controller
{
    public function createForm()
    {
        if (empty(Auth::id())) {
            return redirect()->route('login');
        }
        return view('SocialMediaPlatform/create');
    }

    public function createInstance(Request $request)
    {
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
            ->with('success', 'Social saved.')
            ->with('icon', urlencode($fileName));
    }

    public function edit(Request $request, int $social_id)
    {
        if (empty(Auth::id())) {
            return redirect()->route('login');
        }
        $social_media_platform = SocialMediaPlatform::query()
            ->where('id', '=', $social_id)
            ->first();
        if (empty($social_media_platform)) {
            return redirect()->route('dashboard');
        }
        $vars = [
            'existing_values' => [
                'name' => $social_media_platform->name,
                'logo' => !empty($social_media_platform->logo) ? url($social_media_platform->logo): '',
            ],
            'social_id' => $social_id,
        ];
        return view('SocialMediaPlatform/edit', $vars);
    }

    public function removeLogo(int $social_id)
    {
        if (!empty(Auth::id())) {
            $social_media_platform = SocialMediaPlatform::query()->where('id', '=', $social_id)->first();
            File::delete(public_path().$social_media_platform->logo);
            return response()->json($social_media_platform->update(['logo' => null]))->header('Content-Type', 'application/json');
        }
        return null;
    }

    public function updateInstance(Request $request, int $social_id)
    {
        if (empty(Auth::id())) {
            return redirect()->route('login');
        }
        $social = SocialMediaPlatform::query()
            ->where('id', '=', $social_id)
            ->first();
        if (!empty($social)) {
            $vars = [
                'name' => $request->get('name'),
            ];
            $logo = $request->file('logo');
            if (!empty($logo)) {
                $request->validate([
                    'logo' => 'required|image|max:2048'
                ]);
                $this->removeLogo($social_id);
                $fileName = time().'_'.$request->file('logo')->getClientOriginalName();
                $filePath = $request->file('logo')->storeAs('uploads/images/social-media-platform', urlencode($fileName), 'public');
                $vars['logo'] = '/storage/' . $filePath;
            }
            $social->update($vars);
            return redirect()->route('listSocialMediaPlatforms');
        }
        return redirect()->route('dashboard');
    }

    public function list(Request $request)
    {
        if (empty(Auth::id())) {
            return redirect()->route('login');
        }
        $social_media_platforms = SocialMediaPlatform::all(['id', 'name', 'logo']);
        return view('SocialMediaPlatform/list', ['social_media_platforms' => $social_media_platforms]);
    }
}
