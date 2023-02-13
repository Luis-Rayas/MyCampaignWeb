<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
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
            'img_campaign' => 'mimes:jpg,jpeg,png',
            'inicio_campania' => 'required|date',
            'fin_campania' => 'required|date|after_or_equal:inicio_campania',
            'comentarios' => 'nullable|max:255|alpha:ascii',
        ]);
        $validator->validate();
        dump($request);
        dump($request->file('img_campaign'));

    }
}
