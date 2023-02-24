<?php

namespace App\Http\Controllers;

use App\Models\TypeUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
    * Return the index view
    */
    public function index()
    {

    }

    public function create()
    {
        $typesUser = TypeUser::all();
        return view('user.create')->with([
            'typesUser' => $typesUser
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nombre' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'tipo_usuario' => 'required|exists:type_users,id',
        ]);
        $validator->validate();
        $safe = $validator->safe();
        $user = new User();
        $user->name = $safe['nombre'];
        $user->email = $safe['email'];
        $user->password = Hash::make($safe['password']);
        $typeUser = TypeUser::find($safe['tipo_usuario']);
        $user->save();
        $user->typeUser()->attach($typeUser);
        $user->save();
        $result = (object) [
            'status' => 'success',
            'message' => 'El usuario se ha creado exitosamente!'
        ];
        return redirect()->route('home')->with([
            'result' => $result
        ]);
    }
}
