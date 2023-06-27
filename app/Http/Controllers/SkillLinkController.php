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
        $skill_link = new SkillLink();
        $skill_link->skill = $skill_id;
        $skill_link->user = Auth::id();
        $skill_link->save();
    }
}
