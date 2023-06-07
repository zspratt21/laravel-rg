<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    public function createForm()
    {
        if (empty(Auth::id())) {
            return redirect()->route('login');
        }
        return view('Skill/create');
    }

    public function createInstance(Request $request)
    {
        $request->validate([
            'icon' => 'required|image|max:2048'
        ]);
        dump($request);
        dump($request->file('icon'));
        dump($request->get('name'));
        dump($request->get('description'));
        $fileName = time().'_'.$request->file('icon')->getClientOriginalName();
        dump(urlencode($fileName));
        $filePath = $request->file('icon')->storeAs('uploads/images/skill', $fileName, 'public');
        $skill = new Skill();
        $skill->name = $request->get('name');
        $skill->description = $request->get('description');
        $skill->url = $request->get('url');
        $skill->icon = '/storage/' . $filePath;
        $skill->save();
        return back()
            ->with('success', 'Skill saved.')
            ->with('icon', urlencode($fileName));
    }

    public function edit(Request $request, int $skill_id)
    {
        if (empty(Auth::id())) {
            return redirect()->route('login');
        }
        $skill = Skill::query()
            ->where('id', '=', $skill_id)
            ->first();
        if (empty($skill)) {
            return redirect()->route('dashboard');
        }
        $vars = [
            'existing_values' => [
                'name' => $skill->name,
                'description' => $skill->description,
                'url' => $skill->url,
            ],
            'skill_id' => $skill_id,
        ];
        return view('Skill/edit', $vars);
    }

    public function updateInstance(Request $request, int $skill_id)
    {
        if (empty(Auth::id())) {
            return redirect()->route('login');
        }
        $skill = Skill::query()
            ->where('id', '=', $skill_id)
            ->first();
        if (!empty($skill)) {
            $vars = [
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'url' => $request->get('url'),
            ];
            $skill->update($vars);
            return redirect()->route('listSkills');
        }
        return redirect()->route('dashboard');
    }

    public function list()
    {
        if (empty(Auth::id())) {
            return redirect()->route('login');
        }
        $skills = Skill::all(['id', 'name', 'icon']);
        return view('Skill/list', ['skills' => $skills]);
    }

    public function show(int $skill_id)
    {
        $skill = Skill::query()->where('id', '=', $skill_id)->first();
        $vars = [
            'name' => $skill->name,
            'description' => $skill->description,
            'icon' => $skill->icon,
        ];
        return view('Skill/show', $vars);
    }
}
