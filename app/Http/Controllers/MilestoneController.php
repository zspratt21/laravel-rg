<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Milestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MilestoneController extends Controller
{
    public function createForm()
    {
        if (empty(Auth::id())) {
            return redirect()->route('login');
        }
        $experiences = Experience::query()->where('user', '=', Auth::id())->get(['title', 'id']);
        $experience_options = [];
        foreach ($experiences as $experience) {
            $experience_options[$experience->id] = $experience->title;
        }
        $vars = [
            'experience_options' => $experience_options,
        ];
        dump($experiences);
        dump($vars);
        return view('Milestone/create', $vars);
    }

    public function createInstance(Request $request)
    {
        dump($request);
        dump($request->file('image'));
        dump($request->get('title'));
        dump($request->get('description'));
        dump($request->get('experience'));
        $fileName = time().'_'.$request->file('image')->getClientOriginalName();
        $filePath = $request->file('image')->storeAs('uploads/images/milestone', urlencode($fileName), 'public');
        $milestone = new Milestone();
        $milestone->image = '/storage/' . $filePath;
        $milestone->title = $request->get('title');
        $milestone->description = $request->get('title');
        $milestone->experience = $request->get('experience');
        $milestone->save();
        return back()
            ->with('success', 'Milestone saved.')
            ->with('icon', urlencode($fileName));
    }
}
