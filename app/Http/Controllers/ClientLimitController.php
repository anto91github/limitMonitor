<?php

namespace App\Http\Controllers;

use App\Helpers\AuditTrailHelper;
use App\Http\Requests\ClientLimitRequest;
use App\Models\ClientLimit;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ClientLimitController extends Controller
{
    public function index()
    {
        AuditTrailHelper::add_log('View', '/form_client_limit');

        return view('/form/form_client_limit');
    }


    public function store(ClientLimit $client_limit, ClientLimitRequest $request)
    {

        //For demo purposes only. When creating user or inviting a user
        // you should create a generated random password and email it to the user


        $data_exists = $client_limit->where('Client', $request['client'])->update(
            [
                'ClientLimit' => str_replace(',', "", $request['credit']),
                'Updated_by'=> Auth::user()->uid
            ]
        );

        if (!$data_exists) {
            $client_limit->create(
                [
                    'Client' => $request['client'],
                    'ClientLimit' => str_replace(',', "", $request['credit']),
                    'Updated_by'=> Auth::user()->uid
                ]
            );

            AuditTrailHelper::add_log('Insert', [
                'Client' => $request['client'],
                'ClientLimit' => str_replace(',', "", $request['credit']),
                'Updated_by'=> Auth::user()->uid
            ]);

            return redirect()->route('formclientlimit.index')
                ->withSuccess(__('Created successfully.'));
        } else {
            AuditTrailHelper::add_log('Edit', [
                'Client' => $request['client'],
                'ClientLimit' => $request['credit'],
                'Updated_by'=> Auth::user()->uid
            ]);

            return redirect()->route('formclientlimit.index')
                ->withSuccess(__('Update success.'));
        }
    }

    public function edit($client)
    {
        $clientData = ClientLimit::where('Client', $client)->first();

        AuditTrailHelper::add_log('View', '/form_client_limit/edit'.$clientData);

        return view('/form/form_client_limit', [
            'clientData' => $clientData,
            'isEdit' => true
        ]);
    }

    public function autocomplete(Request $request)
    {
        $search = $request->get('query');
        $data_client = ClientLimit::where('Client', 'LIKE', "%{$search}%")->get();

        return response()->json($data_client);
    }
}
