<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WindowOrder;

class WindowOrderController extends Controller
{
    /**
     * Display all window orders
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = WindowOrder::orderBy('id', 'desc')
            ->whereDate('TrxDate', today())
            ->paginate(10);
        return view('windowOrder/index', ['data' => $data]);
    }

    /**
     * Delete user data
     *
     * @param WindowOrder $WindowOrder
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(WindowOrder $WindowOrder)
    {
        $WindowOrder->delete();

        return redirect()->route('windowOrder.index')
            ->withSuccess(__('Data deleted successfully.'));
    }
}
