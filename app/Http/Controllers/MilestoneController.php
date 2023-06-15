<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Milestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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
        $milestone->description = $request->get('description');
        $milestone->experience = $experience_id;
        if (!empty($request->file('image'))) {
            $fileName = !empty($request->file('image')) ? time().'_'.$request->file('image')->getClientOriginalName() : 'no image was uploaded';
            $filePath = $request->file('image')->storeAs('uploads/images/milestone', urlencode($fileName), 'public');
            $milestone->image = '/storage/' . $filePath;
        }
        $vars = [
            // @debug remove and only return created bool
            'milestone' => $milestone,
            'created' => $milestone->save(),
        ];
        return Response::json($vars);
    }

    public function removeImage(int $milestone_id)
    {
        if (!empty(Auth::id())) {
            $milestone = Milestone::query()->where('id', '=', $milestone_id)->first();
            if (!empty($milestone->image)) {
                File::delete(public_path().$milestone->image);
                return response()->json($milestone->update(['image' => null]))->header('Content-Type', 'application/json');
            }
        }
        return null;
    }

    public function deleteInstance(int $milestone_id)
    {
        $milestone = Milestone::query()->where('id', '=', $milestone_id)->first();
        if (!empty($milestone)) {
            if (!empty($milestone->image)) {
                $this->removeImage($milestone_id);
            }
            $milestone->delete();
            return true;
        }
        return null;
    }

    public function updateInstance(Request $request, int $milestone_id)
    {
        $milestone = Milestone::query()->where('id', '=', $milestone_id)->first();
        if (!empty($milestone)) {
            $vars = [
                'title' => $request->get('title'),
                'description' => $request->get('description'),
            ];
            if (!empty($request->file('image'))) {
                if (!empty($milestone->image)) {
                    $this->removeImage($milestone_id);
                }
                $fileName = time().'_'.$request->file('image')->getClientOriginalName();
                $filePath = $request->file('image')->storeAs('uploads/images/milestone', urlencode($fileName), 'public');
                $vars['image'] = '/storage/' . $filePath;
            }
            $milestone->update($vars);
            return Response::json($vars);
        }
        return null;
    }
}
