<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use App\Models\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpStatus;
use Illuminate\Support\Facades\Validator;

class MunicipalityController extends Controller
{
public function index()
{
    $municipalities = Municipality::select('id', 'name', 'number')->get();
    return view('municipalities.index')->with([
        'municipalities' => $municipalities
    ]);
}

    //API functions
    public function getMunicipalitiesByState(Request $request)
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
        $municipalities = Municipality::select(
            'id',
            'name',
            'number')
            ->whereHas('section', function (Builder $query) use ($safe) {
            $query->where('state_id', $safe['stateId']);
        })->get();
        return response()->json(
            $municipalities
        );
    }

    public function getById(int $id)
    {
        $state = Municipality::find($id);
        if($state == null){
            return response()->json($state, HttpStatus::HTTP_NO_CONTENT);
        }
        return response()->json($state);
    }
}
