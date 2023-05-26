<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\Experience;
use App\Models\SkillLink;
use Illuminate\Support\Facades\Auth;
use StepStone\PDFreactor\PDFreactor;

class ResumeController extends Controller
{
    public function show(string $id)
    {
        $pdfreactor = new PDFreactor(env('PDFREACTOR_HOST', 'http://localhost'), env('PDFREACTOR_PORT', 9423));
        $config = [
            'document'  => view('welcome')->render(),
        ];
        $user = Auth::user();
        $vars = [
            'mobile' => $user->mobile,
            'profile_photo' => $user->profile_photo_path,
            'cover_photo' => 'stub',
            'introduction' => $user->introduction,
            'name' => $user->name,
            'address' => 'stub',
            'skills' => [],
            'experiences' => [],
        ];
        // @todo skills
        //   query skill links and grab url and logo of linked skills
        $linked_skills = SkillLink::query()->where('user', '=', $user->id)->get()->all();
        dump($linked_skills);
        // @todo experiences
        //   split array by type, grab name and image of linked entity, and title, description and dates of experience
        //   include milestones via query on experience_id under experience item(title, image and description)
        $linked_experiences = Experience::query()->where('user', '=', $user->id)->get()->all();
        dump($linked_experiences);
        foreach ($linked_experiences as $experience) {
            $entity = Entity::query()->where('id', '=', $experience->entity)->first();
            dump($entity);
            $experience_data = [
                'title' => $experience->title,
                'description' => $experience->description,
                'date_started' => $experience->date_started,
                'date_ended' => $experience->date_ended,
                'entity_logo' => url($entity->logo),
                'entity_name' => $entity->name,
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
