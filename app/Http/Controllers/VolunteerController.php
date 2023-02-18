<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    /**
    * Return the index view
    */
    public function index()
    {
        return view('volunteers.index');
    }
}
