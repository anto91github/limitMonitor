<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WindowOrder;

class WindowApproveController extends Controller
{
    public function index(Request $request) 
    {
        $keyword = $request->pencarian;
        $today = now()->toDateString();

        $data = WindowOrder::orderBy('id', 'desc')
                            ->where('Status', 'P')
                            ->whereDate('TrxDate', $today)
                            ->where(function($query) use ($keyword) {
                                $query->where('Client', 'LIKE', '%'.$keyword.'%')
                                      ->orWhere('Obligasi', 'LIKE', '%'.$keyword.'%');
                            })
                            ->paginate(10);
        return view('WindowApprove/index',[
            'data' => $data
        ]);
    }

    public function changeStatus($orderId, Request $request)
    {
        try {
           WindowOrder::findOrFail($orderId)->update([
                'Status' => $request['newStatus'],
                'Note' => $request['approveNote']
            ]);
            return redirect()->route('window-approve.index')->withSuccess(__('Update successfully.'));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('window-approve.index')->withErrors(__('Order not found.'));
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors());
            
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Error updating order status: '.$e->getMessage());
            return redirect()->route('window-approve.index')->withErrors(__('Update failed.'));
        }
    }
}
