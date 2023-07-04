<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\SkillLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SkillController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function create()
    {
        return view('Skill/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $skill = new Skill();
        $skill->name = $request->get('name');
        $skill->url = $request->get('url');
        if (!empty($request->file('icon'))) {
            $request->validate([
                'icon' => 'required|image|max:2048'
            ]);
            $fileName = time() . '_' . $request->file('icon')->getClientOriginalName();
            $filePath = $request->file('icon')->storeAs('uploads/images/skill', $fileName, 'public');
            $skill->icon = '/storage/' . $filePath;
        }
        $skill->save();
        return back()
            ->with('success', 'Skill saved.');
    }

    public function edit(int $skill_id)
    {
        $skill = Skill::query()->find($skill_id);
        if (!empty($skill)) {
            $vars = [
                'existing_values' => [
                    'name' => $skill->name,
                    'url' => $skill->url,
                    'icon' => !empty($skill->icon) ? url($skill->icon) : '',
                ],
                'skill_id' => $skill_id,
            ];
            return view('Skill/edit', $vars);
        }
        abort('404', "That skill doesn't exist.");
    }

    public function update(Request $request, int $skill_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $skill = Skill::query()->find($skill_id);
        if (!empty($skill)) {
            $vars = [
                'name' => $request->get('name'),
                'url' => $request->get('url'),
            ];
            $icon = $request->file('icon');
            if (!empty($icon)) {
                $request->validate([
                    'icon' => 'required|image|max:2048'
                ]);
                $this->removeIcon($skill_id);
                $fileName = time() . '_' . $request->file('icon')->getClientOriginalName();
                $filePath = $request->file('icon')->storeAs('uploads/images/skill', urlencode($fileName), 'public');
                $vars['icon'] = '/storage/' . $filePath;
            }
            $skill->update($vars);
            return redirect()->route('skillList');
        }
        abort('404', "That skill doesn't exist.");
    }

    public function list()
    {
        $skills = Skill::all(['id', 'name', 'icon']);
        $user_links = Auth::user()->skillLinks()->pluck('skill_id')->toArray();
        $vars = [
            'skills' => $skills,
            'user_links' => $user_links,
        ];
        return view('Skill/list', $vars);
    }

    public function removeIcon(int $skill_id)
    {
        $skill = Skill::query()->find($skill_id);
        if (!empty($skill)) {
            if (!empty($skill->icon)) {
                File::delete(public_path() . $skill->icon);
                return response()->json($skill->update(['icon' => null]));
            }
        }
        abort('404', "That skill doesn't exist or does not have an icon associated with it.");
    }

    public function delete(int $skill_id)
    {
        $skill = Skill::query()->find($skill_id);
        if (!empty($skill)) {
            $skill->skillLinks()->delete();
            if (!empty($skill->icon)) {
                $this->removeIcon($skill_id);
            }
            return $skill->delete();
        }
        abort('404', "That skill doesn't exist.");
    }
}
