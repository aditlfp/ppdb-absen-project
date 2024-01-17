<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('Admin.User.index');
    }

    public function create()
    {
        return view('Admin.User.create');
    }


    public function edit()
    {
        return view('Admin.User.edit');
    }

    public function show($id)
    {
        
    }
}   
