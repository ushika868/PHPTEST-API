<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

class student extends Controller
{
      public function index()
    {
        $users = DB::select('select * from users');
        dd($users);
        return view('welcome1', ['users' => $users]);
        
    }
}
