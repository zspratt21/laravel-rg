<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EntityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function create()
    {
        return view('Entity/create');
    }

    public function delete(int $entity_id)
    {
        $entity = Entity::query()->find($entity_id);
        if (!empty($entity)) {
            $experiences = Experience::query()->where('entity', '=', $entity_id)->get();
            $controller = new ExperienceController();
            foreach ($experiences as $experience) {
                // @todo consider moving delete functions to models via overwrite for any custom actions/logic
                $controller->delete($experience->id);
            }
            $entity->delete();
            return redirect()->route('entityList');
        }
        // @todo error message
        return null;
    }

    public function edit(int $entity_id)
    {
        $entity = Entity::query()->find($entity_id);
        if (!empty($entity)) {
            $vars = [
                'existing_values' => [
                    'name' => $entity->name,
                    'logo' => !empty($entity->logo) ? url($entity->logo) : '',
                ],
                'entity_id' => $entity_id,
            ];
            return view('Entity/edit', $vars);
        }
        return redirect()->route('dashboard');
    }

    public function list()
    {
        $entities = Entity::all(['id', 'name', 'logo']);
        return view('Entity/list', ['entities' => $entities]);
    }

    public function removeLogo(int $entity_id)
    {
        $entity = Entity::query()->find($entity_id);
        if (!empty($entity)) {
            if (!empty($entity->logo)) {
                File::delete(public_path() . $entity->logo);
                return response()->json($entity->update(['logo' => null]))->header('Content-Type', 'application/json');
            }
        }
        // @todo appropriate error page with 'Either the specified entity does not exist or does not have a logo associated with it'
        return null;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $entity = new Entity();
        $entity->name = $request->get('name');
        if (!empty($request->file('logo'))) {
            $request->validate([
                'logo' => 'required|image|max:2048'
            ]);
            $fileName = time() . '_' . $request->file('logo')->getClientOriginalName();
            $filePath = $request->file('logo')->storeAs('uploads/images/entity', urlencode($fileName), 'public');
        }
        $entity->logo = !empty($filePath) ? '/storage/' . $filePath : '';
        $entity->save();
        return back()
            ->with('success', 'Entity saved.');
    }

    public function update(Request $request, int $entity_id)
    {
        $entity = Entity::query()->find($entity_id);
        if (!empty($entity)) {
            $vars = [
                'name' => $request->get('name'),
            ];
            $logo = $request->file('logo');
            if (!empty($logo)) {
                $request->validate([
                    'logo' => 'required|image|max:2048'
                ]);
                $this->removeLogo($entity_id);
                $fileName = time() . '_' . $request->file('logo')->getClientOriginalName();
                $filePath = $request->file('logo')->storeAs('uploads/images/entity', urlencode($fileName), 'public');
                $vars['logo'] = '/storage/' . $filePath;
            }
            $entity->update($vars);
            return redirect()->route('entityList');
        }
        abort(404, 'The specified entity does not exist.');
    }
}
