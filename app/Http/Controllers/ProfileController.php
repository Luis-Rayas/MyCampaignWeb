<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchCurrentPassword;

class ProfileController extends Controller
{

    public function index()
    {
        $user = User::find(Auth::id());
        $token = JWTAuth::fromUser(Auth::user());
        //dd($user);
        return view('profile.show')->with([
            'user' => $user,
            'image' => $user->adminlte_image(),
            'jwt' => $token
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', new MatchCurrentPassword(Auth::user())],
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|same:newPassword',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->newPassword),
        ]);

        return redirect()->back()->with([ 'message' => 'Contraseña actualizada correctamente.']);
    }
}
