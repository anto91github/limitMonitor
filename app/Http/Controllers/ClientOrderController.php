<?php

namespace App\Http\Controllers;

use App\Helpers\AuditTrailHelper;
use App\Helpers\ClientLimitHelper;
use App\Http\Requests\ClientOrderRequest;
use App\Models\ClientLimit;
use App\Models\Holiday;
use App\Models\WindowOrder;
use Carbon\Carbon;
use DateTime;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class ClientOrderController extends Controller
{
    public function index()
    {
        AuditTrailHelper::add_log('View', '/form_client_order');

        return view('/form/form_client_order');
    }

    public function store(WindowOrder $client_order, ClientOrderRequest $request)
    {

        //For demo purposes only. When creating user or inviting a user
        // you should create a generated random password and email it to the user
        $trx_date = date('Y-m-d');
        $status = 'M';
        $item = ClientLimit::where('Client', $request['client'])->first();
        $limit = ClientLimitHelper::calculateClientLimit($item);
        $status = $limit['status'] == '' ? 'M' : 'P';

        $client_order->create(
            [
                'TrxDate' => $trx_date,
                'SettleDate' => $request['sett_date'],
                'BorS' => $request['bors'],
                'Client' => $request['client'],
                'Obligasi' => $request['obligasi'],
                'Nominal' => str_replace(',', "", $request['nominal']),
                'Harga' => $request['harga'],
                'Amount' => str_replace(',', "", $request['amount']),
                'Uid' => Auth::user()->uid,
                'Status' => $status,
                'CreatedAt' => Carbon::now()
            ]
        );


        AuditTrailHelper::add_log('Insert', [
            'TrxDate' => $trx_date,
            'SettleDate' => $request['sett_date'],
            'BorS' => $request['bors'],
            'Client' => $request['client'],
            'Obligasi' => $request['obligasi'],
            'Nominal' => str_replace(',', "", $request['nominal']),
            'Harga' => $request['harga'],
            'Amount' => str_replace(',', "", $request['amount']),
            'Uid' => Auth::user()->uid,
            'Status' => $status,
            'CreatedAt' => Carbon::now()
        ]);

        return redirect()->route('formclientorder.index')
            ->withSuccess(__('Created successfully.'));
    }

    public function getsett(Request $request)
    {
        $query = $request->get('query');
        $sett_date = date('Y-m-d', strtotime('+' . intval($query) . ' days'));
        $sett_proses = 1;
        while ($this->get_holiday($sett_date)) {
            $sett_date = date('Y-m-d', strtotime($sett_date . '+' . $sett_proses . ' days'));
        }

        return response()->json($sett_date);
    }

    private function get_holiday($date): bool
    {
        $days = new DateTime($date);
        $dayOfWeek = $days->format('w');

        if ($dayOfWeek == 6 || $dayOfWeek == 0) {
            return true;
        }

        $get_holiday = Holiday::where('tanggal', $date)->first();
        if ($get_holiday) {
            return true;
        }

        return false;
    }
}
