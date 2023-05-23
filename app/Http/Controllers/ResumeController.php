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
        $result = $pdfreactor->convertAsBinary($config);
        header("Content-Type: application/pdf");
        echo $result;
    }

}
