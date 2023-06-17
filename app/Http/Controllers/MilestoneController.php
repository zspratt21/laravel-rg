<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Milestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class MilestoneController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function checkExperience(int $experience_id)
    {
        return Experience::query()
            ->where('user', '=', Auth::id())
            ->where('id', '=', $experience_id)
            ->exists();
    }
    public function createForm(int $experience_id)
    {
        if ($this->checkExperience($experience_id)) {
            $vars = [
                'experience_id' => $experience_id,
            ];
            $response_vars = [
                'html' => view('Milestone/create', $vars)->render(),
            ];
            return response()->json($response_vars);
        }
        return response()->json(['error' => 'Experience either does not exist or is not accessible'], 404);
    }

    public function edit(int $milestone_id)
    {
        $milestone = Milestone::query()->find($milestone_id);
        if (!empty($milestone)) {
            if ($this->checkExperience($milestone->experience)) {
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
                return response()->json($response_vars);
            }
        }
        return response()->json(['error' => 'Milestone does not exist'], 404);
    }

    public function createInstance(Request $request, int $experience_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        $milestone = new Milestone();
        $milestone->title = $request->get('title');
        $milestone->description = $request->get('description');
        $milestone->experience = $experience_id;
        if (!empty($request->file('image'))) {
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $filePath = $request->file('image')
                ->storeAs('uploads/images/milestone', urlencode($fileName), 'public');
            $milestone->image = '/storage/' . $filePath;
        }
        $vars = [
            'milestone' => $milestone,
            'created' => $milestone->save(),
        ];
        return response()->json($vars);
    }

    public function removeImage(int $milestone_id)
    {
        $milestone = Milestone::query()->find($milestone_id);
        if (!empty($milestone)) {
            if (!empty($milestone->image)) {
                File::delete(public_path() . $milestone->image);
                return $milestone->update(['image' => null]);
            }
        }
        return response()->json(['error' => 'Milestone does not exist'], 404);
    }

    public function deleteInstance(int $milestone_id)
    {
        $milestone = Milestone::query()->find($milestone_id);
        if (!empty($milestone)) {
            if (!empty($milestone->image)) {
                $this->removeImage($milestone_id);
            }
            return $milestone->delete();
        }
        return response()->json(['error' => 'Milestone does not exist'], 404);
    }

    public function updateInstance(Request $request, int $milestone_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        $milestone = Milestone::query()->find($milestone_id);
        if (!empty($milestone)) {
            $vars = [
                'title' => $request->get('title'),
                'description' => $request->get('description'),
            ];
            if (!empty($request->file('image'))) {
                if (!empty($milestone->image)) {
                    $this->removeImage($milestone_id);
                }
                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $filePath = $request->file('image')
                    ->storeAs('uploads/images/milestone', urlencode($fileName), 'public');
                $vars['image'] = '/storage/' . $filePath;
            }
            return $milestone->update($vars);
        }
        return response()->json(['error' => 'Milestone does not exist'], 404);
    }
}
