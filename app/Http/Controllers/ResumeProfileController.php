<?php

namespace App\Http\Controllers;

use App\Models\ResumeProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResumeProfileController extends Controller
{
    public function getInstance() {
        if(empty(Auth::id())){
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

    public function editInstance(Request $request){
        if (!empty($request->file('cover_photo'))){
            $request->validate([
                'cover_photo' => 'required|image|max:2048000'
            ]);
        }
        $fileName = time().'_'.$request->file('cover_photo')->getClientOriginalName();
        echo 'file name '.$fileName;
        $filePath = $request->file('cover_photo')->storeAs('uploads/images/resume-profile/cover-photo', $fileName, 'public');
        $vars = [
            'address' => $request->get('address'),
            'mobile' => $request->get('mobile'),
            'introduction' => $request->get('introduction'),
            'cover_photo' => '/storage/' . $filePath,
        ];
        $profile = ResumeProfile::query()->where('user', '=', Auth::id())->first();
        $profile->update($vars);
    }
}
