<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    public function createForm(){
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

    public function createInstance(Request $request){
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
            ->with('success','Experience saved.');
    }

    public function show(int $experience_id){
        $experience = Experience::query()->where('id', '=', $experience_id)->first();
        $vars = [];
        return view('experience/show', $vars);
    }
}
