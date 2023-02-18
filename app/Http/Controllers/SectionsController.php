<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpStatus;
use Illuminate\Support\Facades\Validator;

class SectionsController extends Controller
{

        /**
     * Return the index view
     */
    public function index()
    {

    }

    //API Methods
    public function getAllSections(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'stateId' => 'required'
        ]);
        //$validator->validate();
        if($validator->fails()){
            return response()->json([], HttpStatus::HTTP_BAD_REQUEST);
        }
        $sections = Section::select('id',
        'section',
        'state_id',
        'municipality_id',
        'federal_district_id',
        'local_district_id'
        )->where('state_id', $request->input('stateId'))->paginate(500);
        return response()->json($sections);
    }
}
