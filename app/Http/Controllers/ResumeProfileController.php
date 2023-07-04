<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ResumeProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function edit()
    {
        $profile = Auth::user()->resumeProfile;
        $vars = [
            'address' => $profile->address,
            'mobile' => $profile->mobile,
            'introduction' => $profile->introduction,
            'cover_photo' => url($profile->cover_photo),
        ];
        return response()->json($vars);
    }

    public function removeCoverPhoto()
    {
        $profile = Auth::user()->resumeProfile;
        if (!empty($profile->cover_photo)) {
            File::delete(public_path() . $profile->cover_photo);
            return response()->json($profile->update(['cover_photo' => null]));
        }
        return null;
    }

    public function update(Request $request)
    {
        $vars = [
            'address' => $request->get('address'),
            'mobile' => $request->get('mobile'),
            'introduction' => $request->get('introduction'),
        ];
        if (!empty($request->file('cover_photo'))) {
            $request->validate([
                'cover_photo' => 'required|image|max:20480'
            ]);
            $this->removeCoverPhoto();
            $fileName = time() . '_' . $request->file('cover_photo')->getClientOriginalName();
            echo 'file name ' . urlencode($fileName);
            $filePath = $request->file('cover_photo')
                ->storeAs('uploads/images/resume-profile/cover-photo', urlencode($fileName), 'public');
            $vars['cover_photo'] = '/storage/' . $filePath;
        }
        $profile = Auth::user()->resumeProfile;
        return $profile->update($vars);
    }
}
