<?php

namespace App\Helpers;

use App\Models\AuditTrail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

final class AuditTrailHelper
{
    public static function add_log($type, $msg_log)
    {
        $uid = Auth::user()->uid;
        $ip = Request::ip();
        $log = '';
        $datalog = '';

        if (is_array($msg_log)) {
            foreach ($msg_log as $key => $value) {
                $datalog .= $key . ' : ' . $value . ', ';
            }
        }



        switch ($type) {
            case 'Insert':
                $log = 'Insert data ' . $datalog;
                break;
            case 'Edit':
                $log = 'Update data ' . $datalog;
                break;
            case 'View':
                $log = 'View page ' . $msg_log;
                break;
            case 'Login':
                $log = $uid . ' Login';
                break;
            case 'Logout':
                $log = $uid . ' Logout';
                break;

            default:
                $log = $msg_log;
                break;
        }

        AuditTrail::create([
            'Uid' => $uid,
            'Ip' => $ip,
            'Log' => $log
        ]);
    }
}
