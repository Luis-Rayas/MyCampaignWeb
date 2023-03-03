<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\TypeUser;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class VolunteerController extends Controller
{
    /**
    * Return the index view
    */
    public function index()
    {
        $token = JWTAuth::fromUser(Auth::user());
        return view('volunteers.index')->with([
            'jwt' => $token
        ]);
    }

    public function show(int $id)
    {
        return view('volunteers.show');
    }

    //Api Functions
    public function getAllVolunteers(Request $request)
    {
        $campaign = Campaign::whereNull('end_date')->first();

        if($campaign == null){
            $response = (object) [
                'status' => 'error',
                'message' => 'No se ha creado ninguna campaña'
            ];
            return response()->json($response, HttpStatus::HTTP_NOT_ACCEPTABLE);
        }

        $volunteers = Volunteer::query();
        $volunteers->selectRaw(
            "volunteers.id,
            CONCAT(volunteers.name, ' ', volunteers.fathers_lastname, ' ', volunteers.mothers_lastname) AS full_name,
            email,
            phone,
            type_volunteers.name AS volunteer_type,
            aux.notes"
        )
        ->join('aux_volunteers AS aux', 'volunteers.id', '=', 'aux.volunteer_id')
        ->join('type_volunteers', 'aux.type_volunteer_id', '=', 'type_volunteers.id')
        ->where('campaign_id', $campaign->id);

        //Validacion de permisos
        $typeUser = TypeUser::where('nombre', 'Sympathizer')->first();
        $user = User::find(Auth::id());
        $currentTypeUser = $user->typeUser()->first();
        if($currentTypeUser->id === $typeUser->id){
            $volunteers->where('user_id', $user->id);
        }

        //Aplicamos la busqueda que otorgo el usuario
        if ($request->has('search') && !empty($request->search['value'])) {
            $volunteers->where(function ($q) use ($request) {
                $q->where('volunteers.name', 'LIKE', '%' . $request->search['value'] . '%')
                    ->orWhere('volunteers.fathers_lastname', 'LIKE', '%' . $request->search['value'] . '%')
                    ->orWhere('volunteers.mothers_lastname', 'LIKE', '%' . $request->search['value'] . '%')
                    ->orWhere('type_volunteers.name', 'LIKE', '%' . $request->search['value'] . '%')
                    ->orWhere('aux.notes', 'LIKE', '%' . $request->search['value'] . '%');
            });
        }

        $volunteers = $volunteers->paginate($request->input('length', 500));

        // Crear un array con la respuesta
        $response = [
            'draw' => $request->input('draw', 1),
            'recordsTotal' => Volunteer::count(),
            'recordsFiltered' => $volunteers->total(),
            'totalPages' => $volunteers->lastPage(),
            'data' => $volunteers->items(),
        ];

        return response()->json($response);
    }
}
