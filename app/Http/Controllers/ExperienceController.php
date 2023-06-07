<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    public function createForm()
    {
        if (empty(Auth::id())) {
            return redirect()->route('login');
        }
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
        dump($request);
        dump($request->get('title'));
        dump($request->get('description'));
        dump($request->get('date_started'));
        dump($request->get('date_ended'));
        dump($request->get('entity'));
        dump($request->get('type'));
        dump(Auth::id());
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
        if (empty(Auth::id())) {
            return redirect()->route('login');
        }
        $experience = Experience::query()
            ->where('id', '=', $experience_id)
            ->where('user', '=', Auth::id())
            ->first();
        if (empty($experience)) {
            return redirect()->route('dashboard');
        }
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
            'existing_values' => [
                'title' => $experience->title,
                'description' => $experience->description,
                'date_started' => $experience->date_started,
                'date_ended' => $experience->date_ended,
                'entity' => $experience->entity,
                'type' => $experience->type,
            ],
            'experience_id' => $experience_id,
        ];
        // @todo add in dynamic milestone forms submitted by ajax.
        // @todo submit main form and dynamic forms via ajax, trigger form submissions with update button.
        return view('experience/edit', $vars);
    }

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
            $experience->update($vars);
        }
        return redirect()->route('dashboard');
    }

    public function show(int $experience_id)
    {
        $experience = Experience::query()->where('id', '=', $experience_id)->first();
        $vars = [];
        return view('experience/show', $vars);
    }
}
