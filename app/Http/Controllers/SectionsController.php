<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as HttpStatus;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class SectionsController extends Controller
{

    /**
     * Return the index view
     */
    public function index()
    {
        $states = State::select('id', 'name')->orderBy('name')->get();
        $token = JWTAuth::fromUser(Auth::user());
        return view('sections.index')->with([
            'states' => $states,
            'jwt' => $token
        ]);
    }

    //API Methods
    public function getAllSections(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'stateId' => 'required'
        ]);
        //$validator->validate();
        if ($validator->fails()) {
            return response()->json([], HttpStatus::HTTP_BAD_REQUEST);
        }
        $sections = Section::query();
        $sections->select(
            'id',
            'section',
            'state_id',
            'municipality_id',
            'federal_district_id',
            'local_district_id'
        )->where('state_id', $request->input('stateId'));

        //Aplicamos la busqueda que otorgo el usuario
        if ($request->has('search') && !empty($request->search['value'])) {
            $sections->where(function ($q) use ($request) {
                $q->where('id', 'LIKE', '%' . $request->search['value'] . '%')
                    ->orWhere('section', 'LIKE', '%' . $request->search['value'] . '%')
                    ->orWhere('state_id', 'LIKE', '%' . $request->search['value'] . '%')
                    ->orWhere('municipality_id', 'LIKE', '%' . $request->search['value'] . '%')
                    ->orWhere('federal_district_id', 'LIKE', '%' . $request->search['value'] . '%')
                    ->orWhere('local_district_id', 'LIKE', '%' . $request->search['value'] . '%');
            });
        }

        $sections = $sections->paginate($request->input('length', 500));

        // Crear un array con la respuesta
        $response = [
            'draw' => $request->input('draw', 1),
            'recordsTotal' => Section::count(),
            'recordsFiltered' => $sections->total(),
            'totalPages' => $sections->lastPage(),
            'data' => $sections->items(),
        ];

        return response()->json($response);
    }

    public function getById(int $id)
    {
        $state = Section::find($id);
        if($state == null){
            return response()->json($state, HttpStatus::HTTP_NO_CONTENT);
        }
        return response()->json($state);
    }
}
