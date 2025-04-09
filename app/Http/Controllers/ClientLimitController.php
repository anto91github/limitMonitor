<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientLimitRequest;
use App\Models\ClientLimit;
use Illuminate\Http\Request;

class ClientLimitController extends Controller
{
    public function index()
    {
        return view('/form/form_client_limit');
    }

    /**
     * Store a newly created user
     *
     * @param User $user
     * @param StoreUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ClientLimit $client_limit, ClientLimitRequest $request)
    {
       
        //For demo purposes only. When creating user or inviting a user
        // you should create a generated random password and email it to the user
        $client_limit->create([
            'Client' => $request['client'],
            'ClientLimit' => $request['credit']
        ]);

        return redirect()->route('formclientlimit.index')
            ->withSuccess(__('Created successfully.'));
    }
}
