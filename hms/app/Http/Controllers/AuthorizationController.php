<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorizationController extends Controller
{
    public function index(Request $request)
    {
        return view('authorization.index');
    }
}
