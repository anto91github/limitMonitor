<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WindowOrder;

class WindowApproveController extends Controller
{
    public function index() 
    {
        return view('WindowApprove/index');
    }
}
