<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Milestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class MilestoneController extends Controller
{
    public function createForm(int $experience_id)
    {
        if (empty(Auth::id())) {
            return redirect()->route('login');
        }
        $experience = Experience::query()->where('user', '=', Auth::id())->where('id', '=', $experience_id)->first();
        if (empty($experience)) {
            return null;
        }
        $vars = [
            'experience_id' => $experience_id,
        ];
        $response_vars = [
            'html' => view('Milestone/create', $vars)->render(),
        ];
        return Response::json($response_vars);
    }

    public function edit(int $milestone_id)
    {
        $milestone = Milestone::query()->where('id', '=', $milestone_id)->first();
        $vars = [
            'milestone_id' => $milestone_id,
            'existing_values' => [
                'title' => $milestone->title,
                'description' => $milestone->description,
                'image' => !empty($milestone->image) ? url($milestone->image) : '',
            ]
        ];
        $response_vars = [
            'html' => view('Milestone/edit', $vars)->render(),
        ];
        return Response::json($response_vars);
    }

    public function createInstance(Request $request, int $experience_id)
    {
        $milestone = new Milestone();
        $milestone->title = $request->get('title');
        $milestone->description = $request->get('title');
        $milestone->experience = $experience_id;
        if (!empty($request->file('image'))) {
            $fileName = !empty($request->file('image')) ? time().'_'.$request->file('image')->getClientOriginalName() : 'no image was uploaded';
            $filePath = $request->file('image')->storeAs('uploads/images/milestone', urlencode($fileName), 'public');
            $milestone->image = '/storage/' . $filePath;
        }
        $milestone->save();
//        return back()
//            ->with('success', 'Milestone saved.')
//            ->with('icon', urlencode($fileName));
        return Response::json(['milestone' => $milestone]);
    }

    public function updateInstance(Request $request, int $milestone_id)
    {
    }
}
