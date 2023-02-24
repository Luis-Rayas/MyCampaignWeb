<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdministratorsController extends Controller
{
    public function index()
    {
        $admins = User::whereHas('typeUser', function($query){
            $query->where('nombre', 'Administrator');
        })->get();
        return view('user.admins.index')->with([
            'admins' => $admins
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
            return redirect()->route('admin.index')->with([
                'result' => $result
            ]);
        }

        $user->delete();
        $result = (object) [
            'status' => 'success',
            'message' => 'El usuario con id ' . $id . ' fue eliminado exitosamente!'
        ];
        return redirect()->route('admin.index')->with([
            'result' => $result
        ]);
    }
}
