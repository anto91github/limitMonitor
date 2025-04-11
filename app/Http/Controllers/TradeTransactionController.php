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

        // Validasi client name wajib diisi hanya jika form disubmit
        if ($request->has('search')) {
            if (empty($clientName)) {
                return redirect()->back()->withErrors(['client_name' => 'Nama client wajib diisi']);
            }

            if (!empty($clientName)) {
                $query->where('Client', 'like', '%' . $clientName . '%');
            }

            // Filter tanggal
            if (!empty($fromDate) && !empty($toDate)) {
                $query->whereBetween('TrxDate', [$fromDate, $toDate]);
            } elseif (empty($fromDate) && empty($toDate) && !empty($clientName)) {
                // Jika tanggal tidak diisi, tampilkan data sebelum hari ini
                $query->where('TrxDate', '<', now()->format('Y-m-d'));
            }
        } else {
            // Jika belum submit form, kembalikan query kosong
            $query->where('id', '<', 0); // Cara cepat untuk return empty result
        }

        $transactions = $query->orderBy('TrxDate', 'desc')->paginate(10);
        AuditTrailHelper::add_log('View', '/trade-transactions');
        return view('trade_transaction.index', compact('transactions'));
    }
}
