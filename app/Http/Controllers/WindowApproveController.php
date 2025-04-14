<?php

namespace App\Http\Controllers;

use App\Models\WindowOrder;
use Illuminate\Http\Request;
use App\Helpers\AuditTrailHelper;
use Illuminate\Support\Facades\Auth;

class WindowApproveController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->pencarian;
        $today = now()->toDateString();

        $data = WindowOrder::orderBy('id', 'desc')
            ->where('Status', 'P')
            ->whereDate('TrxDate', $today)
            ->where(function ($query) use ($keyword) {
                $query->where('Client', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('Obligasi', 'LIKE', '%' . $keyword . '%');
            })
            ->paginate(10);


        AuditTrailHelper::add_log('View', '/window-approve');

        return view('WindowApprove/index', [
            'data' => $data
        ]);
    }

    public function changeStatus($orderId, Request $request)
    {
        try {
            $order = WindowOrder::findOrFail($orderId);

            $updateData = [
                'Status' => $request['newStatus'],
                'Note' => $request['approveNote'],
            ];

            if ($request['newStatus'] == 'M') {
                $updateData['ApprovedBy'] =  Auth::user()->uid;
                $updateData['ApprovedDate'] = now(); 
            } else if ($request['newStatus'] == 'R'){
                $updateData['RejectedBy'] =  Auth::user()->uid;
                $updateData['RejectedDate'] = now(); 
            }

            $order->update($updateData);            

            AuditTrailHelper::add_log('Edit', [
                'OrderId' => $orderId,
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
            \Log::error('Error updating order status: ' . $e->getMessage());
            return redirect()->route('window-approve.index')->withErrors(__('Update failed.'));
        }
    }
}
