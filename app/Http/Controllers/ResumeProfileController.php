<?php

namespace App\Http\Controllers;

use App\Models\ResumeProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ResumeProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function getInstance()
    {
        if (empty(Auth::id())) {
            return redirect()->route('login');
        }
        $profile = ResumeProfile::query()->where('user', '=', Auth::id())->first();
        $vars = [
            'address' => $profile->address,
            'mobile' => $profile->mobile,
            'introduction' => $profile->introduction,
            'cover_photo' => url($profile->cover_photo),
        ];
        return response()->json($vars)->header('Content-Type', 'application/json');
    }

    public function removeCoverPhoto()
    {
        $profile = ResumeProfile::query()->where('user', '=', Auth::id())->first();
        if (!empty($profile->cover_photo)) {
            File::delete(public_path() . $profile->cover_photo);
            return response()->json($profile->update(['cover_photo' => null]));
        }
        return null;
    }

    public function editInstance(Request $request)
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
            $this->removeCoverPhoto($request);
            $fileName = time() . '_' . $request->file('cover_photo')->getClientOriginalName();
            echo 'file name ' . urlencode($fileName);
            $filePath = $request->file('cover_photo')
                ->storeAs('uploads/images/resume-profile/cover-photo', urlencode($fileName), 'public');
            $vars['cover_photo'] = '/storage/' . $filePath;
        }
        $profile = ResumeProfile::query()->where('user', '=', Auth::id())->first();
        return $profile->update($vars);
    }
}
