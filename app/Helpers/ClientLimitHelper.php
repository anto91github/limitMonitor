<?php
namespace App\Helpers;

use App\Models\ClientLimit;
use App\Models\ClientOrder;
use Carbon\Carbon;

class ClientLimitHelper
{
    public static function calculateClientLimit($clientLimit, $insert_limit = 0)
    {
        // Ambil semua order aktif (P atau M) dan belum melewati SettleDate
        $activeOrders = $clientLimit->orders->filter(function ($order) {
            return in_array($order->Status, ['P', 'M']) &&
                   Carbon::now()->lte(Carbon::parse($order->SettleDate));
        });

        // Total amount yang masih aktif
        $usedLimit = $activeOrders->sum('Amount');
        $availableLimit = $clientLimit->ClientLimit - $usedLimit - $insert_limit;

        return [
            'nama_client' => $clientLimit->Client,
            'credit_limit' => $clientLimit->ClientLimit,
            'used_limit' => $usedLimit,
            'available_limit' => $availableLimit,
            'status' => $availableLimit > 0 ? '' : 'LIMIT REACHED'
        ];
    }
}