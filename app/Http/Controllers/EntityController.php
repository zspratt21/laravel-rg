<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use Illuminate\Http\Request;
use StepStone\PDFreactor\PDFreactor;

class EntityController extends Controller
{
    public function createForm(){
        return view('Entity/create');
    }

    public function createInstance(Request $request){
        $request->validate([
            'logo' => 'required|mimes:png,jpg,svg,jpeg|max:2048'
        ]);
        dump($request);
        dump($request->file('logo'));
        dump($request->get('name'));
        dump($request->get('description'));
        $fileName = time().'_'.$request->file('logo')->getClientOriginalName();
        dump($fileName);
        $filePath = $request->file('logo')->storeAs('uploads/images/entity', $fileName, 'public');
        $entity = new Entity();
        $entity->name = $request->get('name');
        $entity->description = $request->get('description');
        $entity->logo = '/storage/' . $filePath;
        $entity->save();
        return back()
            ->with('success','Entity saved.')
            ->with('logo', $fileName);
    }


    public function show(int $entity_id){
        $entity = Entity::query()->where('id', '=', $entity_id)->first();
        $vars = [
            'name' => $entity->name,
            'description' => $entity->description,
            'logo' => url($entity->logo),
        ];
        dump($vars);
        return view('Entity/show', $vars);
    }

    public function print(int $entity_id){
        $pdfreactor = new PDFreactor(env('PDFREACTOR_HOST', 'http://localhost'), env('PDFREACTOR_PORT', 9423));
        $config = [
            'document'  => $this->show($entity_id)->render(),
//            'baseURL' => 'http://192.168.186.227:8000/'
        ];
        $result = $pdfreactor->convertAsBinary($config);
        header("Content-Type: application/pdf");
        echo $result;
    }
}
