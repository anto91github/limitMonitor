<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientLimitController extends Controller
{
    public function index()
    {
        return view('/form/form_client_limit');
    }
}
