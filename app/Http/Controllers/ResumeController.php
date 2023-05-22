<?php

namespace App\Http\Controllers;

use StepStone\PDFreactor\PDFreactor;

class ResumeController extends Controller
{
    //@todo create milestone model that references experience model.
    //  image - string
    //  title - string
    //  description - text
    //@todo create social media model
    //  logo - string
    //  name - string
    //@todo create social media link that references social media model and user
    //  socialmedia_id - int
    //  user_id - int
    //  link - string
    public function show(string $id)
    {
        $pdfreactor = new PDFreactor(env('PDFREACTOR_HOST', 'http://localhost'), env('PDFREACTOR_PORT', 9423));
        $config = [
            'document'  => view('welcome')->render(),
        ];
        $result = $pdfreactor->convertAsBinary($config);
        header("Content-Type: application/pdf");
        echo $result;
    }

}
