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

    public function delete($client)
    {
        try {

            $clientLimit = ClientLimit::with(['orders' => function($query) {
                $query->whereIn('Status', ['P', 'M'])
                      ->where('SettleDate', '>=', now()->format('Y-m-d'));
            }])->where('Client', $client)->first();
    
            if ($clientLimit->orders->count() > 0) {
                return redirect()->route('client-position.index')
                    ->withErrors(__('Gagal reset limit: Client punya order yang masih aktif'));
            }
      
            ClientLimit::where('Client', $client)->update(
                [
                    'ClientLimit' => 0
                ]
            );

        
            AuditTrailHelper::add_log('Edit',  [
                'lient' => $client,
                'ClientLimit' => str_replace(',', "", 'Reset limit to 0')
            ]);

            return redirect()->route('client-position.index')
                ->withSuccess(__('Client limit has been reset to 0'));
        } catch (\Exception $e) {
            return redirect()->route('client-position.index')
                ->withErrors(__('Failed to reset limit: ') . $e->getMessage());
        }
    }
}
