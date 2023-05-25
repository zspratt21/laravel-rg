<?php

namespace App\Http\Controllers;

use StepStone\PDFreactor\PDFreactor;

class ResumeController extends Controller
{
    public function show(string $id)
    {
        $pdfreactor = new PDFreactor(env('PDFREACTOR_HOST', 'http://localhost'), env('PDFREACTOR_PORT', 9423));
        $config = [
            'document'  => view('welcome')->render(),
        ];
        // @todo user - phone
        // @todo user - profile_photo
        // @todo user - introduction
        // @todo user - name
        // @todo user - address
        // @todo skills
        //   query skill links and grab url and logo of linked skills
        // @todo experiences
        //   split array by type, grab name and image of linked entity, and title, description and dates of experience
        //   include milestones via query on experience_id under experience item(title, image and description)
        $result = $pdfreactor->convertAsBinary($config);
        header("Content-Type: application/pdf");
        echo $result;
    }

}
