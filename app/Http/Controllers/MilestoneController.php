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
            // @todo put existing milestones here
        ];
        $response_vars = [
            'html' => view('Milestone/create', $vars)->render(),
        ];
        return Response::json($response_vars);
    }

    public function getMilestonesFromExperience(int $experience_id)
    {
        $milestones = Milestone::query()->where('experience', '=', $experience_id)->get(['id']);
        foreach ($milestones as $milestone){
            dump($milestone->id);
        }
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
        $fileName = !empty($request->file('image')) ? time().'_'.$request->file('image')->getClientOriginalName() : 'no image was uploaded';
//        dump($request);
        $response_vars = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'image' => $fileName,
            'experience' => $experience_id,
            'experience_form' => (int) $request->get('experience'),
        ];
//        dump($request->file('image'));
//        dump($request->get('title'));
//        dump($request->get('description'));
//        dump($request->get('experience'));
//        $filePath = $request->file('image')->storeAs('uploads/images/milestone', urlencode($fileName), 'public');
//        $milestone = new Milestone();
//        $milestone->image = '/storage/' . $filePath;
//        $milestone->title = $request->get('title');
//        $milestone->description = $request->get('title');
//        $milestone->experience = $request->get('experience');
//        $milestone->save();
//        return back()
//            ->with('success', 'Milestone saved.')
//            ->with('icon', urlencode($fileName));
        return Response::json($response_vars);
    }

    public function updateInstance(Request $request, int $milestone_id)
    {
    }
}
