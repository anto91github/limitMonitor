<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WindowOrder;

class WindowOrderController extends Controller
{
    /**
     * Display all window orders
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $windowOrders = WindowOrder::latest()->paginate(10);

        return view('window.index');
    }
}
