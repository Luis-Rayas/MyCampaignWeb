<?php

namespace App\Http\Controllers;

use App\Models\LocalDistrict;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpStatus;
use Illuminate\Support\Facades\Validator;

class LocalDistrictController extends Controller
{
    /**
    * Return the index view
    */
    public function index()
    {
        $localDistricts = LocalDistrict::select('id', 'name', 'number')->get();
        return view('local-districts.index')->with([
            'localDistricts' => $localDistricts
        ]);
    }

    //API Functions
    public function getLocalDistrictsByState(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'stateId' => 'required|exists:states,id'
        ]);

        if($validator->fails()){
            $response = (object) [
                'status' => 'error',
                'message' => $validator->errors()
            ];
            return response()->json($response, HttpStatus::HTTP_BAD_REQUEST);
        }
        $safe = $validator->safe();
        $localDistricts = LocalDistrict::select(
            'id',
            'name',
            'number')
            ->whereHas('section', function (Builder $query) use ($safe) {
            $query->where('state_id', $safe['stateId']);
        })->get();
        return response()->json(
            $localDistricts
        );
    }
}
