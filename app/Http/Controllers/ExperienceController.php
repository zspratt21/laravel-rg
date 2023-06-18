<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\Experience;
use App\Models\Milestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function createForm()
    {
        $entities = Entity::all(['name', 'id']);
        $entity_options = [];
        foreach ($entities as $entity) {
            $entity_options[$entity->id] = $entity->name;
        }
        $vars = [
            'type_options' => [
                'experience' => 'Employment',
                'education' => 'Education',
            ],
            'entity_options' => $entity_options,
        ];
        return view('Experience/create', $vars);
    }

    public function createInstance(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date_started' => 'required|date',
            'date_ended' => 'required|date',
            'entity' => 'required|int',
            'type' => 'required|string|max:255',
        ]);
        $experience = new Experience();
        $experience->title = $request->get('title');
        $experience->description = $request->get('description');
        $experience->date_started = $request->get('date_started');
        $experience->date_ended = $request->get('date_ended');
        $experience->entity = $request->get('entity');
        $experience->type = $request->get('type');
        $experience->user = Auth::id();
        $experience->save();
        return back()
            ->with('success', 'Experience saved.');
    }

    public function edit(int $experience_id)
    {
        $experience = Experience::query()
            ->where('id', '=', $experience_id)
            ->where('user', '=', Auth::id())
            ->first();
        if (!empty($experience)) {
            $entities = Entity::all(['name', 'id']);
            $entity_options = [];
            foreach ($entities as $entity) {
                $entity_options[$entity->id] = $entity->name;
            }
            $milestones = Milestone::query()->where('experience', '=', $experience_id)->get();
            $milestone_edit_forms = [];
            if (!empty($milestones)) {
                foreach ($milestones as $milestone) {
                    $vars = [
                        'milestone_id' => $milestone->id,
                        'existing_values' => [
                            'title' => $milestone->title,
                            'description' => $milestone->description,
                            'image' => !empty($milestone->image) ? url($milestone->image) : '',
                        ],
                    ];
                    $milestone_edit_forms[] = view('Milestone/edit', $vars)->render();
                }
            }
            $vars = [
                'type_options' => [
                    'experience' => 'Employment',
                    'education' => 'Education',
                ],
                'entity_options' => $entity_options,
                'existing_values' => [
                    'title' => $experience->title,
                    'description' => $experience->description,
                    'date_started' => $experience->date_started,
                    'date_ended' => $experience->date_ended,
                    'entity' => $experience->entity,
                    'type' => $experience->type,
                ],
                'experience_id' => $experience_id,
                'milestone_edit_forms' => $milestone_edit_forms,
            ];
            return view('experience/edit', $vars);
        }
        return response()->json(['error' => 'Experience does not exist'], 404);
    }

    // @todo add in other details from entity to make it look nice
    public function list(Request $request)
    {
        if (empty(Auth::id())) {
            return redirect()->route('login');
        }
        $experiences = Experience::query()->where('user', '=', Auth::id())->get(['id', 'title', 'entity']);
        return view('Experience/list', ['experiences' => $experiences]);
    }

    public function updateInstance(Request $request, int $experience_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date_started' => 'required|date',
            'date_ended' => 'required|date',
            'entity' => 'required|int',
            'type' => 'required|string|max:255',
        ]);
        $experience = Experience::query()->where('user', '=', Auth::id())->where('id', '=', $experience_id)->first();
        if (!empty($experience)) {
            $vars = [
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'date_started' => $request->get('date_started'),
                'date_ended' => $request->get('date_ended'),
                'entity' => $request->get('entity'),
                'type' => $request->get('type'),
            ];
            return $experience->update($vars);
        }
        return response()->json(['error' => 'Experience does not exist'], 404);
    }

    public function deleteInstance(int $experience_id)
    {
        $milestones = Milestone::query()->where('experience', '=', $experience_id)->get();
        if (!empty($milestones)) {
            $controller = new MilestoneController();
            foreach ($milestones as $milestone) {
                $controller->deleteInstance($milestone->id);
            }
        }
        return Experience::query()->find($experience_id)->delete();
    }
}
