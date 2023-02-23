<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CampaignsController extends Controller
{

    public function index()
    {
        $campaigns = Campaign::all();
        return view('campaigns.index')->with([
            'campaigns' => $campaigns
        ]);
    }
    /**
     * Return the show view
     */
    public function show(int $id)
    {
        $currentCampaign = Campaign::find($id);
        $imgPath = null;
        if (isset($currentCampaign->img_path)) {
            $imgPath = Storage::url($currentCampaign->img_path);
        } else {
            $imgPath = Storage::url('img/logo.png');
        }
        return view('campaigns.show')->with([
            'campaign' => $currentCampaign,
            'imgPath' => $imgPath
        ]);
    }

    /**
     * Return the create view
     */
    public function create(): View
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
        if ($request->file('img_campaign')) {
            $img_path = Storage::disk('public')
                ->put('img/campaigns/' . $campaign->name . '/logo/', $request->file('img_campaign'));
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

    public function edit(int $id)
    {
        $campaign = Campaign::find($id);

        return view('campaigns.edit')->with([
            'campaign' => $campaign
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:campaigns,id',
            'nombre' => 'required|max:255|alpha_spaces',
            'partido' => 'required|max:50|alpha:ascii',
            'img_campaign' => 'mimes:jpg,jpeg,png',
            'inicio_campania' => 'required|date',
            'fin_campania' => 'required|date|after_or_equal:inicio_campania',
            'descripcion' => 'nullable|max:255|alpha_spaces',
        ]);
        $validator->validate();
        $safe = $validator->validated();
        $campaign = Campaign::find($safe['id']);
        $campaign->name = isset($safe['nombre']) ? $safe['nombre'] : null;
        if ($request->file('img_campaign')) {
            $img_path = Storage::disk('public')
                ->put('img/campaigns/' . $campaign->name . '/logo/', $request->file('img_campaign'));
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
            'message' => 'Campaña modificada con exito con exito!'
        ];
        return redirect()->route('campaign.index')->with(['result' => $result]);
    }

    public function delete(int $id)
    {
        $campaign = Campaign::find($id);
        if ($campaign == null) {
            $result = (object) [
                'status' => 'danger',
                'message' => 'La campaña ' . $id . ' no existe'
            ];
            return redirect()->route('campaign.index')->with([
                'result' => $result
            ]);
        }
        $campaign->end_date = Carbon::now();
        $campaign->save();
        $result = (object) [
            'status' => 'success',
            'message' => 'La campaña ' . $id . ' fue concluido con exito!'
        ];
        return redirect()->route('campaign.index')->with([
            'result' => $result
        ]);
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
