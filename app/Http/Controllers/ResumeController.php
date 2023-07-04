<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use StepStone\PDFreactor\PDFreactor;

class ResumeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function prepare()
    {
        $user = Auth::user();
        $profile = $user->resumeProfile;
        $vars = [
            'mobile' => $profile->mobile,
            'profile_photo' => url('storage/' . $user->profile_photo_path),
            'cover_photo' => !empty($profile->cover_photo) ? url($profile->cover_photo) : '',
            'introduction' => $profile->introduction,
            'name' => $user->name,
            'email' => $user->email,
            'address' => $profile->address,
            'socials' => [],
            'skills' => [],
            'experiences' => [],
        ];
        $social_links = $user->socialLinks()->get()->all();
        if (!empty($social_links)) {
            foreach ($social_links as $social_link) {
                if (!empty($social_link->social_media_platform_id)) {
                    $vars['socials'][] = [
                        'logo' => url($social_link->platform->logo),
                        'url' => $social_link->url,
                    ];
                }
            }
        }
        $linked_skills = $user->skillLinks()->orderBy('created_at')->get()->all();
        foreach ($linked_skills as $linked_skill) {
            if (!empty($linked_skill->skill_id)) {
                $vars['skills'][] = [
                    'name' => $linked_skill->skill->name,
                    'icon' => !empty($linked_skill->skill->icon) ? url($linked_skill->skill->icon) : '',
                    'url' => !empty($linked_skill->skill->url) ? $linked_skill->skill->url : '',
                ];
            }
        }
        $linked_experiences = $user->experiences()->orderBy('date_started', 'DESC')->get()->all();
        foreach ($linked_experiences as $experience) {
            $milestone_data = [];
            $milestones = $experience->milestones()->orderBy('created_at')->get()->all();
            if (!empty($milestones)) {
                foreach ($milestones as $milestone) {
                    $milestone_data[] = [
                        'title' => $milestone->title,
                        'description' => $milestone->description,
                        'image' => !empty($milestone->image) ? url($milestone->image) : '',
                    ];
                }
            }
            $experience_data = [
                'title' => $experience->title,
                'description' => $experience->description,
                'date_started' => Carbon::parse($experience->date_started)->format('M Y'),
                'date_ended' => !empty($experience->date_ended) ? Carbon::parse($experience->date_ended)->format('M Y') : 'Present',
                'entity_logo' => url($experience->entity->logo),
                'entity_name' => $experience->entity->name,
                'milestones' => $milestone_data,
            ];
            $vars['experiences'][ucfirst($experience->type)][] = $experience_data;
        }

        return $vars;
    }

    public function show()
    {
        $user = Auth::user();
        $vars = $this->prepare();
        $pdfreactor = new PDFreactor(env('PDFREACTOR_HOST', 'http://localhost'), env('PDFREACTOR_PORT', 9423));
        $config = [
            'document'  => view('Resume/og', $vars)->render(),
        ];
        $result = $pdfreactor->convertAsBinary($config);
        header("Content-Type: application/pdf");
        header('Content-Disposition: inline; filename="' . $user->name . ' - Resume - ' . time() . '.pdf"');
        echo $result;
    }

    public function debug()
    {
        $vars = $this->prepare();
        return view('Resume/og', $vars);
    }
}
