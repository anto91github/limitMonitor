<?php

namespace App\Http\Controllers;

use App\Models\WindowOrder;
use Illuminate\Http\Request;
use App\Helpers\AuditTrailHelper;

class TradeTransactionController extends Controller
{
    public function index(Request $request)
    {

        $clientName = $request->input('client_name');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $query = WindowOrder::query();

        $query->where('Status', 'M');


        if ($request->has('search') || $request->has('page')) {

            if (!empty($clientName)) {
                $query->where('Client', 'like', '%' . $clientName . '%');
            }

            if (!empty($fromDate) && !empty($toDate)) {
                $query->whereBetween('TrxDate', [$fromDate, $toDate]);
            } elseif (empty($fromDate) && empty($toDate) && !empty($clientName)) {
                $query->where('TrxDate', '<', now()->format('Y-m-d'));
            }
        } else {
            $query->where('id', '<', 0); 
        }

        $transactions = $query->orderBy('TrxDate', 'desc')->paginate(10);
        AuditTrailHelper::add_log('View', '/trade-transactions/'. $clientName);
        return view('trade_transaction.index', compact('transactions'));
    }
}
