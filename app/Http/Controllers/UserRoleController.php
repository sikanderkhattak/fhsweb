<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserRoleController extends Controller
{
    public function index()
    {
        $roles=User::all();
        return view('admin.role.index',compact('roles'));
    }
    public function create()
    {
        return view('admin.role.create');
    }



}
