<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use StepStone\PDFreactor\PDFreactor;

class EntityController extends Controller
{
    public function createForm()
    {
        if (empty(Auth::id())) {
            return redirect()->route('login');
        }
        return view('Entity/create');
    }

    public function createInstance(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|max:2048'
        ]);
        dump($request);
        dump($request->file('logo'));
        dump($request->get('name'));
        dump($request->get('description'));
        $fileName = time() . '_' . $request->file('logo')->getClientOriginalName();
        dump($fileName);
        $filePath = $request->file('logo')->storeAs('uploads/images/entity', urlencode($fileName), 'public');
        $entity = new Entity();
        $entity->name = $request->get('name');
        $entity->description = $request->get('description');
        $entity->logo = !empty($filePath) ? '/storage/' . $filePath : '';
        $entity->save();
        return back()
            ->with('success', 'Entity saved.')
            ->with('logo', urlencode($fileName));
    }

    public function list(Request $request)
    {
        if (empty(Auth::id())) {
            return redirect()->route('login');
        }
        $entities = Entity::all(['id', 'name', 'logo']);
        return view('Entity/list', ['entities' => $entities]);
    }

    public function edit(Request $request, int $entity_id)
    {
        if (empty(Auth::id())) {
            return redirect()->route('login');
        }
        $entity = Entity::query()
            ->where('id', '=', $entity_id)
            ->first();
        if (empty($entity)) {
            return redirect()->route('dashboard');
        }
        $vars = [
            'existing_values' => [
                'name' => $entity->name,
                'description' => $entity->description,
                'logo' => !empty($entity->logo) ? url($entity->logo) : '',
            ],
            'entity_id' => $entity_id,
        ];
        return view('Entity/edit', $vars);
    }

    public function removeLogo(int $entity_id)
    {
        if (!empty(Auth::id())) {
            $entity = Entity::query()->where('id', '=', $entity_id)->first();
            File::delete(public_path() . $entity->logo);
            return response()->json($entity->update(['logo' => null]))->header('Content-Type', 'application/json');
        }
        return null;
    }

    public function updateInstance(Request $request, int $entity_id)
    {
        if (empty(Auth::id())) {
            return redirect()->route('login');
        }
        $entity = Entity::query()
            ->where('id', '=', $entity_id)
            ->first();
        if (!empty($entity)) {
            $vars = [
                'name' => $request->get('name'),
                'description' => $request->get('description'),
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
            return redirect()->route('listEntities');
        }
        return redirect()->route('dashboard');
    }
}
