<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Milestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class MilestoneController extends Controller
{
    public function createForm(int $experience_id)
    {
        if (empty(Auth::id())) {
            return redirect()->route('login');
        }
        $experience = Experience::query()->where('user', '=', Auth::id())->where('id', '=', $experience_id)->first();
        if (empty($experience)) {
            return null;
        }
        $vars = [
            'experience_id' => $experience_id,
        ];
        $response_vars = [
            'html' => view('Milestone/create', $vars)->render(),
        ];
        return Response::json($response_vars);
    }

    public function createInstance(Request $request, int $experience_id)
    {
//        dump($request);
        $response_vars = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
        ];
        return Response::json($response_vars);
//        dump($request->file('image'));
//        dump($request->get('title'));
//        dump($request->get('description'));
//        dump($request->get('experience'));
//        $fileName = time().'_'.$request->file('image')->getClientOriginalName();
//        $filePath = $request->file('image')->storeAs('uploads/images/milestone', urlencode($fileName), 'public');
//        $milestone = new Milestone();
//        $milestone->image = '/storage/' . $filePath;
//        $milestone->title = $request->get('title');
//        $milestone->description = $request->get('title');
//        $milestone->experience = $request->get('experience');
//        $milestone->save();
//        return back()
//            ->with('success', 'Milestone saved.')
//            ->with('icon', urlencode($fileName));
    }
}
