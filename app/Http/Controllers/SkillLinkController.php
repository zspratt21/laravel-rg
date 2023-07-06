<?php

namespace App\Http\Controllers;

use App\Models\SkillLink;
use Illuminate\Support\Facades\Auth;

class SkillLinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function store(int $skill_id)
    {
        if (Auth::user()->skillLinks()->where('skill_id', '=', $skill_id)->exists()) {
            abort(500, 'This skill is already linked to your account');
        } else {
            $skill_link = new SkillLink();
            $skill_link->skill_id = $skill_id;
            $skill_link->user_id = Auth::id();
            $skill_link->save();
            return back();
        }
    }

    public function delete(int $skill_id)
    {
        $link = Auth::user()->skillLinks()->where('skill_id', '=', $skill_id);
        if ($link->exists()) {
            $link->delete();
            return back();
        } else {
            abort(404, "Either that skill link does not exist or isn't associated with your account");
        }
    }
}
