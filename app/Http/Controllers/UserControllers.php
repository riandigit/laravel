<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\App;

class UserControllers extends Controller
{
    //
    public function index(){
        return User::all();
    }

    public function createtoken(){
        return bcrypt(env('APP_ID'));
    }
}
