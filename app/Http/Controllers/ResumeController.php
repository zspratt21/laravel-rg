<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\Experience;
use App\Models\Milestone;
use App\Models\Skill;
use App\Models\SkillLink;
use App\Models\SocialMediaLink;
use App\Models\SocialMediaPlatform;
use Illuminate\Support\Facades\Auth;
use StepStone\PDFreactor\PDFreactor;

class ResumeController extends Controller
{
    public function show(string $id)
    {
        // @todo make custom profile model for introduction, mobile, address and cover photo. Include edit form in jetstream profile form/page

        $pdfreactor = new PDFreactor(env('PDFREACTOR_HOST', 'http://localhost'), env('PDFREACTOR_PORT', 9423));
        $config = [
            'document'  => view('welcome')->render(),
        ];
        $user = Auth::user();
        $vars = [
            'mobile' => 'stub',
            'profile_photo' => url('storage/' . $user->profile_photo_path),
            'cover_photo' => 'stub',
            'introduction' => 'stub',
            'name' => $user->name,
            'email' => $user->email,
            'address' => 'stub',
            'socials' => [],
            'skills' => [],
            'experiences' => [],
        ];
        $social_links = SocialMediaLink::query()->where('user', '=', $user->id)->get()->all();
        if (!empty($social_links)) {
            foreach ($social_links as $social_link) {
                $social_platform = SocialMediaPlatform::query()->where('id', '=', $social_link->social_media_platform)->first();
                if (!empty($social_platform)) {
                    $vars['socials'][] = [
                        'logo' => url($social_platform->logo),
                        'url' => $social_link->url,
                    ];
                }
            }
        }
        // @todo skills
        //   query skill links and grab url and logo of linked skills
        $linked_skills = SkillLink::query()->where('user', '=', $user->id)->get()->all();
        dump($linked_skills);
        foreach ($linked_skills as $linked_skill) {
            $skill = Skill::query()->where('id', '=', $linked_skill->skill)->first();
            dump($skill);
            if (!empty($skill)) {
                $vars['skills'][] = [
                    'name' => $skill->name,
                    'icon' => url($skill->icon),
                    'url' => 'stub',
                ];
            }
        }
        $linked_experiences = Experience::query()->where('user', '=', $user->id)->get()->all();
        dump($linked_experiences);
        foreach ($linked_experiences as $experience) {
            $entity = Entity::query()->where('id', '=', $experience->entity)->first();
            dump($entity);
            $milestone_data = [];
            $milestones = Milestone::query()->where('experience', $experience->id)->get()->all();
            dump($milestones);
            if (!empty($milestones)) {
                foreach ($milestones as $milestone) {
                    $milestone_data[] = [
                        'title' => $milestone->title,
                        'description' => $milestone->description,
                        'image' => url($milestone->image),
                    ];
                }
            }
            $experience_data = [
                'title' => $experience->title,
                'description' => $experience->description,
                'date_started' => $experience->date_started,
                'date_ended' => !empty($experience->date_ended) ? $experience->date_ended : 'Present',
                'entity_logo' => url($entity->logo),
                'entity_name' => $entity->name,
                'milestones' => $milestone_data,
            ];

            dump($experience_data);
            $vars['experiences'][$experience->type][] = $experience_data;
        }
        dump($vars);
//        $result = $pdfreactor->convertAsBinary($config);
//        header("Content-Type: application/pdf");
//        echo $result;
    }

}
