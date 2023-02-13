<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\TypeUser;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CampaignsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Return the index view
     */
    public function index()
    {
        return view('campaigns.index');
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
            'nombre' => 'required|max:255|alpha:ascii',
            'partido' => 'required|max:50|alpha:ascii',
            'img_campaign' => 'mimes:jpg,jpeg,png',
            'inicio_campania' => 'required|date',
            'fin_campania' => 'required|date|after_or_equal:inicio_campania',
            'descripcion' => 'nullable|max:255|alpha:ascii',
        ]);
        $validator->validate();
        dump($validator->validated());
        $safe = $validator->validated();
        $campaign = new Campaign();
        $campaign->name = isset($safe['nombre']) ? $safe['nombre'] : null;
        $campaign->img_path = isset($safe['img_campaign']) ? $safe['img_campaign'] : null; //img_campaign
        $campaign->party = isset($safe['partido']) ? $safe['partido'] : null;
        $campaign->start_date = isset($safe['inicio_campania']) ? $safe['inicio_campania'] : null;
        $campaign->end_date = isset($safe['fin_campania']) ? $safe['fin_campania'] : null;
        $campaign->description = isset($safe['descripcion']) ? $safe['descripcion'] : null;
        $campaign->user_id = Auth::user()->id;
        dump($campaign);
        $campaign->save();
        dump($campaign);
    }
}
