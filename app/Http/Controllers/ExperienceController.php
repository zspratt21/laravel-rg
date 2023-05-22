<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function createForm(){
        return view('experience/create');
    }

    public function createInstance(Request $request){
        // @todo manually add logged in user's id to new experience instance
        // @todo complete form template and process data
    }

    public function show(int $experience_id){
        $experience = Experience::query()->where('id', '=', $experience_id)->first();
        $vars = [];
        return view('experience/show', $vars);
    }
}
