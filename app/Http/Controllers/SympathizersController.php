<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SympathizersController extends Controller
{
    public function index()
    {
        $sympathizers = User::whereHas('typeUser', function($query){
            $query->where('nombre', 'Sympathizer');
        })->get();
        return view('user.sympathizers.index')->with([
            'sympathizers' => $sympathizers
        ]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        # code...
    }

    public function edit()
    {
        # code...
    }

    public function update(Request $request)
    {
        # code...
    }

    public function delete(int $id)
    {
        $user = User::find($id);
        if($user == null){
            $result = (object) [
                'status' => 'danger',
                'message' => 'El usuario con id ' . $id . ' no existe.'
            ];
            return redirect()->route('sympathizer.index')->with([
                'result' => $result
            ]);
        }
        $user->delete();
        $result = (object) [
            'status' => 'success',
            'message' => 'El usuario con id ' . $id . ' fue eliminado exitosamente!'
        ];
        return redirect()->route('sympathizer.index')->with([
            'result' => $result
        ]);
    }
}
