<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StateController extends Controller
{
        /**
     * Return the index view
     */
    public function index()
    {
        $states = State::select('id', 'name')->get();
        return view('states.index')->with([
            'states' => $states
        ]);
    }

    //API Methods
    public function getAllStates()
    {
        $states = State::select('id', 'name')->orderBy('name')->get();
        $httStatus = Response::HTTP_OK;
        if($states->count() == 0){
            $httStatus = Response::HTTP_NO_CONTENT;
        }
        return response()->json($states, $httStatus);
    }
}
