<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\AuxVolunteer;
use App\Models\Campaign;
use App\Models\FederalDistrict;
use App\Models\LocalDistrict;
use App\Models\Municipality;
use App\Models\Section;
use App\Models\TypeUser;
use App\Models\User;
use App\Models\Volunteer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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
        $volunteer = Volunteer::with([
        'address',
        'auxVolunteer.typeVolunteer',
        'campaign',
        'section.state',
        'section.federalDistrict',
        'section.localDistrict',
        'section.municipality',
        ])->where('id', $id)->first();
        $token = JWTAuth::fromUser(Auth::user());
        //dd($volunteer);
        return view('volunteers.show')->with([
            'volunteer' => $volunteer,
            'jwt' => $token
        ]);
    }

    //Api Functions
    public function getAllVolunteers(Request $request)
    {
        $campaign = Campaign::whereNull('end_date')->first();

        if ($campaign == null) {
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
        if ($currentTypeUser->id === $typeUser->id) {
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

    public function getAllVolunteersForMobile()
    {
        $campaign = Campaign::whereNull('end_date')->first();

        if ($campaign == null) {
            $response = (object) [
                'status' => 'error',
                'message' => 'No se ha creado ninguna campaña'
            ];
            return response()->json($response, HttpStatus::HTTP_NOT_ACCEPTABLE);
        }

        $volunteers = Volunteer::where('campaign_id', $campaign->id)
            ->where('user_id', Auth::id())
            ->with(['address', 'auxVolunteer', 'campaign',
            'section.state',
            'section.federalDistrict',
            'section.localDistrict',
            'section.municipality',
            ])
            ->get();

        return response()->json($volunteers);
    }

    public function getImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idVolunteer' => 'required|exists:volunteers,id',
            'image' => 'required|in:ine,firm'
        ],
        [
            'in' => 'El campo tipo debe ser uno de los valores permitidos: \'ine\' o \'firm\'.',
        ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors(), HttpStatus::HTTP_BAD_REQUEST);
        }
        $volunteerQuery = DB::table('aux_volunteers');
        $image = null;
        switch ($request->input('image')) {
            case 'ine':
                $volunteerQuery->select('image_path_ine AS path');
                break;

            case 'firm':
                $volunteerQuery->select('image_path_firm AS path');
                break;
        }
        $image = $volunteerQuery->where('volunteer_id', $request->input('idVolunteer'))->first();

        if($image->path == null || !file_exists($image->path)){
            return response()->json(null, HttpStatus::HTTP_NO_CONTENT);
        }
        return response()->download($image->path);
    }

    public function saveVolunteer(Request $request)
    {
        try {
            if ($request->isJson() == false) {
                $response = (object) [
                    'status' => 'error',
                    'message' => 'La peticion debe ser tipo JSON'
                ];
                return response()->json($response, HttpStatus::HTTP_BAD_REQUEST);
            }

            $volunteerRequest = $request->json()->all();
            //Validaciones
            //State Validation
            $stateValidation = $this->stateValidation($volunteerRequest['section']['state']);
            if ($stateValidation['valid'] == false) {
                $response = (object) [
                    'entities' => [
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
            if (
                $municipalityValidation['valid'] == false
                || $localDistricValidation['valid'] == false
                || $federalDistricValidation['valid'] == false
            ) {
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
            //Section
            $sectionValidation = $this->sectionValidation(
                $stateValidation['entity']->id,
                $municipalityValidation['entity']->id,
                $localDistricValidation['entity']->id,
                $federalDistricValidation['entity']->id,
                $volunteerRequest['section']
            );
            if ($sectionValidation['valid'] == false) {
                $response = (object) [
                    'entities' => [
                        (object) [
                            'name' => 'section',
                            'message' => $sectionValidation['message']
                        ]
                    ]
                ];
                return response()->json($response, HttpStatus::HTTP_BAD_REQUEST);
            }
            //----------------------------------------------
            $campaign = Campaign::whereNull('end_date')->first();
            if($campaign == null) {
                $response = (object) [
                    'entities' => [
                        (object) [
                            'name' => 'section',
                            'message' => 'No hay una campaña vigente donde asociar el voluntario']
                        ]
                    ];
                return response()->json($response, HttpStatus::HTTP_CONFLICT);
            }

            DB::beginTransaction();
            try {
                $volunteer = Volunteer::create([
                    'name' => $volunteerRequest['name'],
                    'fathers_lastname' => $volunteerRequest['fathersLastname'],
                    'mothers_lastname' => $volunteerRequest['mothersLastname'],
                    'email' => $volunteerRequest['email'],
                    'phone' => $volunteerRequest['phone'],
                    'section_id' => $sectionValidation['entity']->id,
                    'user_id' => Auth::id(),
                    'campaign_id' => $campaign->id,
                ]);

                $address = Address::create([
                    'street' => $volunteerRequest['address']['street'],
                    'external_number' => $volunteerRequest['address']['externalNumber'],
                    'internal_number' => $volunteerRequest['address']['internalNumber'],
                    'suburb' => $volunteerRequest['address']['suburb'],
                    'zipcode' => $volunteerRequest['address']['zipcode'],
                    'volunteer_id' => $volunteer->id,
                ]);

                $inePath = $this->parseBase64ToFile($volunteerRequest['imageCredential'], true);
                $firmPath = $this->parseBase64ToFile($volunteerRequest['imageFirm'], false);

                AuxVolunteer::create([
                    'image_path_ine' => $inePath,
                    'image_path_firm' => $firmPath,
                    'birthdate' => Carbon::create($volunteerRequest['birthdate']['year'], $volunteerRequest['birthdate']['month'], $volunteerRequest['birthdate']['day']),
                    'sector' => $volunteerRequest['sector'],
                    'type_volunteer_id' => $volunteerRequest['type'],
                    'notes' => $volunteerRequest['notes'],
                    'elector_key' => $volunteerRequest['electorKey'],
                    'local_voting_booth' => $volunteerRequest['localVotingBooth'],
                    'volunteer_id' => $volunteer->id,
                ]);
                DB::commit();
            } catch (\Throwable $th) {
                $this->deleteImages($inePath);
                $this->deleteImages($firmPath);
                DB::rollBack();
                $response = (object) [
                    'status' => 'error',
                    'message' => $th->getMessage()
                ];
                return response()->json($response, HttpStatus::HTTP_INTERNAL_SERVER_ERROR);
            }
            $response = (object) [
                'status' => 'success',
                'message' => $volunteer->id
            ];
            return response()->json($response);
        } catch (\Throwable $e){
            $response = (object) [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
            return response()->json($response, HttpStatus::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function deleteImages(string $path)
    {
        Storage::disk('private')->delete($path);
    }

    private function parseBase64ToFile(string $base64Str, bool $isFirma): string
    {
        // Decodificar la cadena base64 a una cadena binaria
        $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Str));

        // Generar un nombre de archivo único para la imagen
        if($isFirma){
            $filename = 'img'.DIRECTORY_SEPARATOR.'credencials'.DIRECTORY_SEPARATOR.'ine'.DIRECTORY_SEPARATOR. uniqid() . '.png';
        } else {
            $filename = 'img'.DIRECTORY_SEPARATOR.'credencials'.DIRECTORY_SEPARATOR.'signature'.DIRECTORY_SEPARATOR. uniqid() . '.png';
        }


        // Guardar la imagen en el disco privado de Laravel
        Storage::disk('private')->put($filename, $image_data);

        // Obtener la ruta completa del archivo guardado
        $file_path = Storage::disk('private')->path($filename);

        return $file_path;
    }

    //Validations
    private function stateValidation(array $state): array
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

        switch ($stateDB->count()) {
            case 0: //No concuerda ni el ID ni el nombre
                //estado con ID 0 por peticion del cliente
                $result['valid'] = false;
                $result['message'] = (object) ['id' => 0];
                return $result;
            case 1: //Al menos 1 de los parametros concuerda
                if ($stateDB[0]->id == $state['id'] && $stateDB[0]->name == $state['name']) { //Si ambos parametros concuerda, pasa
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
            default:
                //envio el primer objeto que encontro
                $result['valid'] = false;
                $result['message'] = $stateDB[0]; //El objeto que resulto
                return $result;
        }
    }

    private function municipalityValidation(array $municipality, int $stateId): array
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

        switch ($municipalityDB->count()) {
            case 0: //No concuerda ni el ID ni el nombre
                //estado con ID 0 por peticion del cliente
                $result['valid'] = false;
                $result['message'] = (object) ['id' => 0];
                return $result;
            case 1: //Al menos 1 de los parametros concuerda
                if ($municipalityDB[0]->number == $municipality['number'] && $municipalityDB[0]->name == $municipality['name']) { //Si ambos parametros concuerda, pasa
                    $result['valid'] = true;
                    $result['entity'] = $municipalityDB[0];
                } else { //sino error
                    $result['valid'] = false;
                    $result['message'] = $municipalityDB[0]; //El objeto que resulto
                }
                return $result;
            default: //Ambos parametros concuerdan
                //envio el primer objeto que encontro
                $result['valid'] = false;
                $result['message'] = $municipalityDB[0]; //El objeto que resulto
                return $result;
        }
    }

    private function localDistrictValidation(array $localDistrict, int $stateId): array
    {
        $result = array();

        if ($localDistrict['id'] != 0) {
            $localDistricDB = LocalDistrict::find($localDistrict['id']);
            if ($localDistricDB->name == $localDistrict['name'] && $localDistricDB->number == $localDistrict['number']) { //Todo concuerda
                $result['valid'] = true;
                $result['entity'] = $localDistricDB;
                return $result;
            }
            $result['valid'] = false;
            $result['message'] = $localDistricDB;
            return $result;
        }

        $localDistricPosible = DB::table('local_districts')
            ->select('local_districts.id', 'local_districts.number', 'local_districts.name')
            ->join('sections', 'sections.local_district_id', '=', 'local_districts.id')
            ->where(function ($query) use ($localDistrict) {
                $query->where('name', 'LIKE', $localDistrict['name']);
                $query->orWhere('number', $localDistrict['number']);
            })
            ->where('sections.state_id', $stateId)->first();

        if ($localDistricPosible != null) {
            $result['valid'] = false;
            $result['message'] = $localDistricPosible; //El objeto que resulto
        } else {
            $result['valid'] = false;
            $result['message'] = (object) ['id' => 0];
        }
        return $result;
    }

    private function federalDistrictValidation(array $federalDistrict, int $stateId): array
    {
        $result = array();

        if ($federalDistrict['id'] != 0) {
            $federalDistrictDB = FederalDistrict::find($federalDistrict['id']);
            if ($federalDistrictDB->name == $federalDistrict['name'] && $federalDistrictDB->number == $federalDistrict['number']) { //Todo concuerda
                $result['valid'] = true;
                $result['entity'] = $federalDistrictDB;
                return $result;
            }
            $result['valid'] = false;
            $result['message'] = $federalDistrictDB;
            return $result;
        }

        $federalDistrictPosible = DB::table('federal_districts')
            ->select('federal_districts.id', 'federal_districts.number', 'federal_districts.name')
            ->join('sections', 'sections.federal_district_id', '=', 'federal_districts.id')
            ->where(function ($query) use ($federalDistrict) {
                $query->where('name', 'LIKE', $federalDistrict['name']);
                $query->orWhere('number', $federalDistrict['number']);
            })
            ->where('sections.state_id', $stateId)->first();

        if ($federalDistrictPosible != null) {
            $result['valid'] = false;
            $result['message'] = $federalDistrictPosible; //El objeto que resulto
        } else {
            $result['valid'] = false;
            $result['message'] = (object) ['id' => 0];
        }
        return $result;
    }

    private function sectionValidation(int $stateId, int $municipalityId, int $localDistrictId, int $federalDistrictId, array $section): array
    {
        $result = array();

        if ($section['id'] != 0) {
            $sectionDB = Section::find($section['id']);
            if ($sectionDB != null && $sectionDB->section == $section['section']) {
                $result['valid'] = true;
                $result['entity'] = $sectionDB;
                return $result;
            }
            $result['valid'] = false;
            $result['message'] = $sectionDB;
            return $result;
        }

        $sectionDB = Section::where('state_id', $stateId)
            ->where('municipality_id', $municipalityId)
            ->where('local_district_id', $localDistrictId)
            ->where('federal_district_id', $federalDistrictId)
            ->where('section', $section['section'])->first();

        if ($sectionDB == null) {
            $sectionDB = Section::where('state_id', $stateId)
                ->where('municipality_id', $municipalityId)
                ->where('local_district_id', $localDistrictId)
                ->where('federal_district_id', $federalDistrictId)
                ->first();

            if ($sectionDB != null) {
                $newSection = new Section();
                $newSection->section = $section['section'];
                $newSection->new = true;
                $newSection->state_id = $stateId;
                $newSection->municipality_id = $municipalityId;
                $newSection->local_district_id = $localDistrictId;
                $newSection->federal_district_id = $federalDistrictId;
                $newSection->save();

                $result['valid'] = true;
                $result['entity'] = $newSection;
                return $result;
            } else {
                $result['valid'] = false;
                $result['message'] = (object) ['id' => 0];
            }
            return $result;
        }

        $result['valid'] = true;
        $result['entity'] = $sectionDB;
        return $result;
    }
}
