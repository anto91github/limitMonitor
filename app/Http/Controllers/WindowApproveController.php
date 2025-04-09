<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WindowApproveController extends Controller
{
    public function index() 
    {
        return view('WindowApprove/index');
    }
}
