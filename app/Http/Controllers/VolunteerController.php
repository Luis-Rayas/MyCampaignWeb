<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Municipality;
use App\Models\Section;
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

    public function saveVolunteer(Request $request)
    {
        if($request->isJson() == false){
            $response = (object) [
                'status' => 'error',
                'message' => 'La peticion debe ser tipo JSON'
            ];
            return response()->json($response, HttpStatus::HTTP_BAD_REQUEST);
        }

        $volunteerRequest = $request->json()->get('volunteer');
        //Validaciones
        //State Validation
        $stateValidation = $this->stateValidation($volunteerRequest['section']['state']);
        if($stateValidation['valid'] == false){
            $response = (object) [
                'entity' => [
                    (object) [
                        'name' => 'state',
                        'message' => $stateValidation['message']
                    ]
                ]
            ];
            return response()->json($response, HttpStatus::HTTP_BAD_REQUEST);
        }
        //--------------------
        $municipalityValidation = $this->municipalityValidation($volunteerRequest['section']['municipality'], $stateValidation['entity']->id);
        $localDistricValidation = $this->localDistrictValidation($volunteerRequest['section']['localDistrict'], $stateValidation['entity']->id);
        $federalDistricValidation = $this->federalDistrictValidation($volunteerRequest['section']['federalDistrict'], $stateValidation['entity']->id);
        if($municipalityValidation['valid'] == false
            || $localDistricValidation['valid'] == false
            || $federalDistricValidation['valid'] == false
            ){
            $entities = [];
            $municipalityValidation['valid'] == false ? array_push($entities, (object) [
                'name' => 'municipality',
                'message' => $municipalityValidation['message']
            ]) : null;
            $localDistricValidation['valid'] == false ? array_push($entities, (object) [
                'name' => 'localDistric',
                'message' => $localDistricValidation['message']
            ]) : null;
            $federalDistricValidation['valid'] == false ? array_push($entities, (object) [
                'name' => 'federalDistric',
                'message' => $federalDistricValidation['message']
            ]) : null;
            $response = (object) [
                'entities' => $entities

            ];
            return response()->json($response, HttpStatus::HTTP_BAD_REQUEST);
        }
        //----------------------------------------------
        dump($volunteerRequest['section']['municipality']['id']);
        dd($volunteerRequest);

    }

    //Validations
    private function stateValidation(array $state) : array
    {
        $stateName = DB::table('states')
        ->select('id', 'name')
        ->where('name', 'LIKE', $state['name']);

        $stateDB = DB::table('states')
        ->select('id', 'name')
        ->where('id', $state['id'])
        ->union($stateName)
        ->get();

        $result = array();

        switch($stateDB->count()){
            case 0: //No concuerda ni el ID ni el nombre
                //estado con ID 0 por peticion del cliente
                $result['valid'] = false;
                $result['message'] = 0;
                return $result;
            case 1: //Al menos 1 de los parametros concuerda
                if($stateDB[0]->id == $state['id'] && $stateDB[0]->name == $state['name']) {//Si ambos parametros concuerda, pasa
                    $result['valid'] = true;
                    $result['entity'] = $stateDB[0];
                } else { //sino error
                    $result['valid'] = false;
                    $result['message'] = $stateDB[0]; //El objeto que resulto
                }
                return $result;
            case 2: //Ambos parametros concuerdan
                //envio el primer objeto que encontro
                $result['valid'] = false;
                $result['message'] = $stateDB[0]; //El objeto que resulto
                return $result;
        }
    }

    private function municipalityValidation(array $municipality, int $stateId) : array
    {
        $muicipalityName = DB::table('municipalities')
        ->select('municipalities.id', 'municipalities.number', 'municipalities.name')
        ->join('sections', 'sections.municipality_id', '=', 'municipalities.id')
        ->where('name', 'LIKE', $municipality['name'])
        ->where('sections.state_id', $stateId);

        $municipalityDB = DB::table('municipalities')
        ->select('municipalities.id', 'municipalities.number', 'municipalities.name')
        ->join('sections', 'sections.municipality_id', '=', 'municipalities.id')
        ->where('number', $municipality['number'])
        ->where('sections.state_id', $stateId)
        ->union($muicipalityName)
        ->get();

        $result = array();

        switch($municipalityDB->count()){
            case 0: //No concuerda ni el ID ni el nombre
                //estado con ID 0 por peticion del cliente
                $result['valid'] = false;
                $result['message'] = 0;
                return $result;
            case 1: //Al menos 1 de los parametros concuerda
                if($municipalityDB[0]->number == $municipality['number'] && $municipalityDB[0]->name == $municipality['name']) {//Si ambos parametros concuerda, pasa
                    $result['valid'] = true;
                    $result['entity'] = $municipalityDB[0];
                } else { //sino error
                    $result['valid'] = false;
                    $result['message'] = $municipalityDB[0]; //El objeto que resulto
                }
                return $result;
            case 2: //Ambos parametros concuerdan
                //envio el primer objeto que encontro
                $result['valid'] = false;
                $result['message'] = $municipalityDB[0]; //El objeto que resulto
                return $result;
        }
        return $result;
    }

    private function localDistrictValidation(array $localDistrict, int $stateId) : array
    {
        $localDistricName = DB::table('local_districts')
        ->select('local_districts.id', 'local_districts.number', 'local_districts.name')
        ->join('sections', 'sections.local_district_id', '=', 'local_districts.id')
        ->where('name', 'LIKE', $localDistrict['name'])
        ->where('sections.state_id', $stateId);

        $localDistricDB = DB::table('local_districts')
        ->select('local_districts.id', 'local_districts.number', 'local_districts.name')
        ->join('sections', 'sections.local_district_id', '=', 'local_districts.id')
        ->where('number', $localDistrict['number'])
        ->where('sections.state_id', $stateId)
        ->union($localDistricName)
        ->get();

        $result = array();

        switch($localDistricDB->count()){
            case 0: //No concuerda ni el ID ni el nombre
                //estado con ID 0 por peticion del cliente
                $result['valid'] = false;
                $result['message'] = 0;
                return $result;
            case 1: //Al menos 1 de los parametros concuerda
                if($localDistricDB[0]->number == $localDistrict['number'] && $localDistricDB[0]->name == $localDistrict['name']) {//Si ambos parametros concuerda, pasa
                    $result['valid'] = true;
                    $result['entity'] = $localDistricDB[0];
                } else { //sino error
                    $result['valid'] = false;
                    $result['message'] = $localDistricDB[0]; //El objeto que resulto
                }
                return $result;
            case 2: //Ambos parametros concuerdan
                //envio el primer objeto que encontro
                $result['valid'] = false;
                $result['message'] = $localDistricDB[0]; //El objeto que resulto
                return $result;
        }
        return $result;
    }

    private function federalDistrictValidation(array $federalDistrict, int $stateId) : array
    {
        $federalDistrictName = DB::table('federal_districts')
        ->select('federal_districts.id', 'federal_districts.number', 'federal_districts.name')
        ->join('sections', 'sections.federal_district_id', '=', 'federal_districts.id')
        ->where('name', 'LIKE', $federalDistrict['name'])
        ->where('sections.state_id', $stateId);

        $federalDistrictsDB = DB::table('federal_districts')
        ->select('federal_districts.id', 'federal_districts.number', 'federal_districts.name')
        ->join('sections', 'sections.federal_district_id', '=', 'federal_districts.id')
        ->where('number', $federalDistrict['number'])
        ->where('sections.state_id', $stateId)
        ->union($federalDistrictName)
        ->get();

        $result = array();

        switch($federalDistrictsDB->count()){
            case 0: //No concuerda ni el ID ni el nombre
                //estado con ID 0 por peticion del cliente
                $result['valid'] = false;
                $result['message'] = 0;
                return $result;
            case 1: //Al menos 1 de los parametros concuerda
                if($federalDistrictsDB[0]->number == $federalDistrict['number'] && $federalDistrictsDB[0]->name == $federalDistrict['name']) {//Si ambos parametros concuerda, pasa
                    $result['valid'] = true;
                    $result['entity'] = $federalDistrictsDB[0];
                } else { //sino error
                    $result['valid'] = false;
                    $result['message'] = $federalDistrictsDB[0]; //El objeto que resulto
                }
                return $result;
            case 2: //Ambos parametros concuerdan
                //envio el primer objeto que encontro
                $result['valid'] = false;
                $result['message'] = $federalDistrictsDB[0]; //El objeto que resulto
                return $result;
        }
        return $result;
    }

    private function sectionValidation(int $stateId, int $municipalityId, int $localDistrictId, int $federalDistrictId, int $section) : array
    {
        $section = Section::where('state_id', $stateId)
        ->where('municipality_id', $municipalityId)
        ->where('local_district_id', $localDistrictId)
        ->where('federal_district_id', $federalDistrictId)
        ->first();

        return array();
    }
}
