<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnAuthorizedController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(!Auth::authenticate()){
            $cantAdmins = User::whereRelation('typeUser', 'type_user_id','=', 1)->get();
            return view('welcome')->with(['existAdmin' => $cantAdmins->count() == 0 ? false : true ]);
        } else {
            return redirect('/dashboard');
        }
    }
}
