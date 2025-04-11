<?php

namespace App\Http\Controllers;

use App\Helpers\AuditTrailHelper;
use Illuminate\Http\Request;
use App\Models\ClientLimit;
use App\Helpers\ClientLimitHelper;
use DB;

class ClientPositionController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->pencarian;

        $clientLimits = ClientLimit::with('orders')
            ->when($keyword, function ($query, $keyword) {
                return $query->where('Client', 'LIKE', '%' . $keyword . '%');
            })
            ->paginate(10)
            ->through(function ($item) {
                return ClientLimitHelper::calculateClientLimit($item);
            });

        AuditTrailHelper::add_log('View', '/client-position');

        return view('clientPosition.index', ['clientLimits' => $clientLimits]);
    }
}
