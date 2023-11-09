<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    //
    function register(Request $req)
    {
        $user = new User;
        $user->name= $req->Input('name');
        $user->email= $req->Input('email');
        $user->password= Hash::make($req->Input('password'));
        $user->save();
        return $user;
    }

    function login(Request $req)
    {
        $user = User::where('email',$req->email)->first();
        if(!$user || !Hash::check($req->password,$user->password))
        {
            return ["error"=>"Email or Password Is Not Match"];
        }
        return $user;
    }
}
