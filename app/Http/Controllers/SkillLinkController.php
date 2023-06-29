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
        $link = SkillLink::query()->where('skill', '=', $skill_id)->where('user', '=', Auth::id());
        if ($link->exists()) {
            abort(500, 'This skill is already linked to your account');
        } else {
            $skill_link = new SkillLink();
            $skill_link->skill = $skill_id;
            $skill_link->user = Auth::id();
            $skill_link->save();
        }
    }

    public function delete(int $skill_id)
    {
        $link = SkillLink::query()->where('skill', '=', $skill_id)->where('user', '=', Auth::id());
        if ($link->exists()) {
            $link->delete();
            return back(200);
        } else {
            abort(404, "Either that skill link does not exist or isn't associated with your account");
        }
    }
}
