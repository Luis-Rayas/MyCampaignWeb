<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
}
