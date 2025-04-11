<?php

namespace App\Http\Controllers;

use App\Models\WindowOrder;
use Illuminate\Http\Request;
use App\Helpers\AuditTrailHelper;

class WindowOrderController extends Controller
{
    /**
     * Display all window orders
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->pencarian;

        $data = WindowOrder::orderBy('id', 'desc')
            ->whereDate('TrxDate', today())
            ->where(function ($query) use ($keyword) {
                $query->where('Client', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('Obligasi', 'LIKE', '%' . $keyword . '%');
            })
            ->paginate(10);

        AuditTrailHelper::add_log('View', '/window-order');

        return view('windowOrder/index', ['data' => $data]);
    }

    // /**
    //  * Delete user data
    //  *
    //  * @param WindowOrder $WindowOrder
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(WindowOrder $WindowOrder)
    // {
    //     $WindowOrder->delete();

    //     return redirect()->route('windowOrder.index')
    //         ->withSuccess(__('Data deleted successfully.'));
    // }
}
