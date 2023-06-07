<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use StepStone\PDFreactor\PDFreactor;

class EntityController extends Controller
{
    public function createForm(){
        if(empty(Auth::id())){
            return redirect()->route('login');
        }
        return view('Entity/create');
    }

    public function createInstance(Request $request){
        $request->validate([
            'logo' => 'required|image|max:2048'
        ]);
        dump($request);
        dump($request->file('logo'));
        dump($request->get('name'));
        dump($request->get('description'));
        $fileName = time().'_'.$request->file('logo')->getClientOriginalName();
        dump($fileName);
        $filePath = $request->file('logo')->storeAs('uploads/images/entity', urlencode($fileName), 'public');
        $entity = new Entity();
        $entity->name = $request->get('name');
        $entity->description = $request->get('description');
        $entity->logo = !empty($filePath) ? '/storage/' . $filePath : '';
        $entity->save();
        return back()
            ->with('success','Entity saved.')
            ->with('logo', urlencode($fileName));
    }

    public function list(Request $request){
        if(empty(Auth::id())){
            return redirect()->route('login');
        }
        $entities = Entity::all(['id', 'name', 'logo']);
        return view('Entity/list', ['entities' => $entities]);
    }

    public function show(int $entity_id){
        $entity = Entity::query()->where('id', '=', $entity_id)->first();
        $vars = [
            'name' => $entity->name,
            'description' => $entity->description,
            'logo' => url($entity->logo),
        ];
        return view('Entity/show', $vars);
    }

    public function print(int $entity_id){
        $pdfreactor = new PDFreactor(env('PDFREACTOR_HOST', 'http://localhost'), env('PDFREACTOR_PORT', 9423));
        $config = [
            'document'  => $this->show($entity_id)->render(),
            'debugSettings' => ['all' => TRUE],
        ];
        $result = $pdfreactor->convertAsBinary($config);
        header("Content-Type: application/pdf");
        echo $result;
    }
}
