<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CampaignsController extends Controller
{
    /**
     * Return the index view
     */
    public function index()
    {
        $currentCampaign = Campaign::first([
            'id',
            'name',
            'party',
            'description',
            'start_date',
            'end_date',
        ]);
        return view('campaigns.index')->with([
            'campaign' => $currentCampaign
        ]);
    }

    /**
     * Return the create view
     */
    public function create() : View
    {
        return view('campaigns.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255|alpha_spaces',
            'partido' => 'required|max:50|alpha:ascii',
            'img_campaign' => 'mimes:jpg,jpeg,png',
            'inicio_campania' => 'required|date',
            'fin_campania' => 'required|date|after_or_equal:inicio_campania',
            'descripcion' => 'nullable|max:255|alpha_spaces',
        ]);
        $validator->validate();
        $safe = $validator->validated();
        $campaign = new Campaign();
        $campaign->name = isset($safe['nombre']) ? $safe['nombre'] : null;
        if($request->file('img_campaign')){
            $img_path = Storage::disk('local')->put('/img/campaigns/logos/'.$campaign->name, $request->file('img_campaign'));
            $campaign->img_path = $img_path;
        }
        $campaign->party = isset($safe['partido']) ? $safe['partido'] : null;
        $campaign->start_date = isset($safe['inicio_campania']) ? $safe['inicio_campania'] : null;
        $campaign->end_date = isset($safe['fin_campania']) ? $safe['fin_campania'] : null;
        $campaign->description = isset($safe['descripcion']) ? $safe['descripcion'] : null;
        $campaign->user_id = Auth::user()->id;
        $campaign->save();
        $result = (object) [
            'status' => 'success',
            'message' => 'Campaña creada con exito!'
        ];
        return redirect()->route('home')->with(['result' => $result]);
    }

    //API Functions
    public function getCurrentCampaign()
    {
        $campaigns = Campaign::select([
            'id',
            'name',
            'party',
            'description',
            'start_date',
            'end_date',
        ])->orderBy('id', 'DESC')->first();
        return response()->json($campaigns);
    }
}
