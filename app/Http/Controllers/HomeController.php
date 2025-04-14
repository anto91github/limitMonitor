<?php

namespace App\Http\Controllers;

use App\Models\ClientLimit;
use App\Models\WindowOrder;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $count_client = ClientLimit::count();
        $count_pending = WindowOrder::where('status', 'P')->count();

        return view('home', ['count_client' => $count_client, 'count_pending' => $count_pending]);
    }

    public function about()
    {
        return view('about');
    }
}
