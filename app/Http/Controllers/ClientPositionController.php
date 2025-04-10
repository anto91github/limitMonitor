<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientLimit;
use App\Models\ClientOrder;
use DB;

class ClientPositionController extends Controller
{
    public function index()
    {
        // Ambil data client limit dan hitung used limit (hitung hanya status P dan M)
        $clientLimits = ClientLimit::leftJoin(
            DB::raw('(SELECT client, SUM(amount) as total_amount 
      FROM client_order 
      WHERE status IN (\'P\', \'M\')
      GROUP BY client) as orders'),
            function ($join) {
                $join->on('client_limit.client', '=', 'orders.client');
            }
        )
            ->select(
                'client_limit.client',
                'client_limit.clientLimit',
                DB::raw('COALESCE(orders.total_amount, 0) as usedLimit'),
                DB::raw('client_limit.clientLimit - COALESCE(orders.total_amount, 0) as remainingLimit')
            )
            ->paginate(10);

        return view('clientPosition.index', compact('clientLimits'));
    }
}
