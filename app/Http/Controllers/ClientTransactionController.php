<?php

namespace App\Http\Controllers;

use App\Models\WindowOrder;
use Illuminate\Http\Request;
use App\Helpers\AuditTrailHelper;
use Illuminate\Support\Facades\DB;

class ClientTransactionController extends Controller
{
    public function index(Request $request)
    {

        $clientName = $request->input('client_name');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $query = WindowOrder::query();

        if ($request->has('search') || $request->has('page')) {
            if (empty($clientName)) {
                return redirect()->back()->withErrors(['client_name' => 'Nama client wajib diisi']);
            }

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

        AuditTrailHelper::add_log('View', '/client-position/'. $clientName);
        
        return view('client_transactions.index', compact('transactions'));
    }
}