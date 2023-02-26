<?php

namespace App\Http\Controllers;

use App\Models\FederalDistrict;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpStatus;
use Illuminate\Support\Facades\Validator;

class FederalDistrictController extends Controller
{
    /**
     * Return the index view
     */
    public function index()
    {
        $federalDistricts = FederalDistrict::select('id', 'name', 'number')->get();
        return view('federal-districts.index')->with([
            'federalDistricts' => $federalDistricts
        ]);
    }

    //API Functions
    public function getFederalDistrictsByState(Request $request)
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
        $federalDistricts = FederalDistrict::select(
            'id',
            'name',
            'number')
            ->whereHas('section', function (Builder $query) use ($safe) {
            $query->where('state_id', $safe['stateId']);
        })->get();
        return response()->json(
            $federalDistricts
        );
    }
}
