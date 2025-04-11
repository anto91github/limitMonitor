<?php

namespace App\Http\Controllers;

use App\Helpers\AuditTrailHelper;
use App\Http\Requests\ClientLimitRequest;
use App\Models\ClientLimit;
use Illuminate\Http\Request;

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
                'ClientLimit' => $request['credit']
            ]
        );

        if (!$data_exists) {
            $client_limit->create(
                [
                    'Client' => $request['client'],
                    'ClientLimit' => $request['credit']
                ]
            );
            
            AuditTrailHelper::add_log('Insert', [
                'Client' => $request['client'],
                'ClientLimit' => $request['credit']
            ]);

            return redirect()->route('formclientlimit.index')
                ->withSuccess(__('Created successfully.'));
        } else {
            AuditTrailHelper::add_log('Edit', [
                'Client' => $request['client'],
                'ClientLimit' => $request['credit']
            ]);

            return redirect()->route('formclientlimit.index')
                ->withSuccess(__('Update success.'));
        }
    }

    public function autocomplete(Request $request)
    {
        $search = $request->get('query');
        $data_client = ClientLimit::where('Client', 'LIKE', "%{$search}%")->get();

        return response()->json($data_client);
    }
}
