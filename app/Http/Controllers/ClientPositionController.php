<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientLimit;
use App\Helpers\ClientLimitHelper;
use DB;

class ClientPositionController extends Controller
{
    public function index()
    {
        $clientLimits = ClientLimit::with('orders')
            ->paginate(10); // atau sesuai kebutuhan

        $clientLimits = $clientLimits->getCollection()->map(function ($item) {
            return ClientLimitHelper::calculateClientLimit($item);
        });

        // inject kembali hasil map ke paginator agar pagination tetap jalan
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $clientLimits,
            $clientLimits->count(),
            10, // per page
            request()->input('page', 1),
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('clientPosition.index', ['clientLimits' => $paginated]);
    }
}
