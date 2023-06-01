<?php

namespace App\Http\Controllers;

use App\Models\ResumeProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResumeProfileController extends Controller
{
    public function editForm() {
        if(empty(Auth::id())){
            return redirect()->route('login');
        }
        $profile = ResumeProfile::query()->where('user', '=', Auth::id())->first();
        $vars = [
            'address' => $profile->address,
            'mobile' => $profile->mobile,
            'introduction' => $profile->introduction,
        ];
        dump($vars);
        return view('ResumeProfile/edit', $vars);
    }

    public function editInstance(Request $request){
        dump($request);

//        if (!empty($request->file('cover_photo'))){
//            $request->validate([
//                'cover_photo' => 'required|image|max:2048'
//            ]);
//        }
//        $fileName = time().'_'.$request->file('cover_photo')->getClientOriginalName();
//        $filePath = $request->file('cover_photo')->storeAs('uploads/images/resume-profile/cover-photo', $fileName, 'public');
//        $vars = [
//            'address' => $request->get('address'),
//            'mobile' => $request->get('mobile'),
//            'introduction' => $request->get('introduction'),
//            'cover_photo' => '/storage/' . $filePath,
//        ];
//        $profile = ResumeProfile::query()->where('user', '=', Auth::id())->first();
//        $profile->update($vars);
    }
}
