<?php
namespace App\Helpers;

use App\Models\ClientLimit;
use App\Models\ClientOrder;
use Carbon\Carbon;

class ClientLimitHelper
{
    public static function calculateClientLimit($clientLimit, $insert_limit = 0)
    {

        if ($clientLimit->ClientLimit == 0) {
            return [
                'nama_client' => $clientLimit->Client,
                'credit_limit' => 0,
                'used_limit' => 0,
                'available_limit' => 0,
                'status' => 'INACTIVE',
                'update_by' => $clientLimit->Update_by,
                'update_at' => $clientLimit->Update_at
            ];
        }

        // Ambil semua order aktif (P atau M) dan belum melewati SettleDate
        $activeOrders = $clientLimit->orders->filter(function ($order) {
            return in_array($order->Status, ['P', 'M']) &&
                   Carbon::now()->lte(Carbon::parse($order->SettleDate));
        });

        // Total amount yang masih aktif
        $usedLimit = $activeOrders->sum('Amount');
        $availableLimit = $clientLimit->ClientLimit - $usedLimit - $insert_limit;

         $status = '';
        if ($availableLimit <= 0) {
            $status = 'LIMIT REACHED';
        }

        return [
            'nama_client' => $clientLimit->Client,
            'credit_limit' => $clientLimit->ClientLimit,
            'used_limit' => $usedLimit,
            'available_limit' => $availableLimit,
            'status' => $status,
            'update_by' => $clientLimit->Update_by,
            'update_at' => $clientLimit->Update_at
        ];
    }
}