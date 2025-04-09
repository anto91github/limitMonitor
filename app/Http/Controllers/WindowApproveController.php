<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WindowOrder;

class WindowApproveController extends Controller
{
    public function index() 
    {
        $data = WindowOrder::orderBy('id', 'desc')
                            ->where('Status', 'P')
                            ->paginate(10);
        return view('WindowApprove/index',[
            'data' => $data
        ]);
    }
}
