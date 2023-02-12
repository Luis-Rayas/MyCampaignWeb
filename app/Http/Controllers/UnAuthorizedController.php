<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UnAuthorizedController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cantAdmins = User::whereRelation('typeUser', 'type_user_id','=', 1)->get();
        return view('welcome')->with(['existAdmin' => $cantAdmins->count() == 0 ? false : true ]);
    }
}
