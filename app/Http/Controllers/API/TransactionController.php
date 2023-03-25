<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $status = $request->input('status');

        if ($id) {
            $transaction = Transaction::with(['items.tours'])->find($id);

            if($transaction) {
                return ResponseFormatter::success(
                    $transaction,
                    'Data transaksi berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data transaksi tidak ada',
                    404
                );
            }
        }

        $transaction = Transaction::with(['items.tours'])->where('users_id', Auth::user()->id);

        if ($status) {
            $transaction->where('status', $status);
        }

        return ResponseFormatter::success(
            $transaction->paginate($limit),
            'Data list transaksi berhasil diambil'
        );
    }

    public function booking(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'exists:tours,id',
            'total_price' => 'required',
            'fee' => 'required',
            'status' => 'required|in:PENDING,SUCCESS,CANCELLED,ACTIVE'
        ]);

        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'choose_date' => $request->choose_date,
            'total_price' => $request->total_price,
            'fee' => $request->fee,
            'status' => $request->status,
        ]);

        foreach ($request->items as $tours) {
            TransactionItem::create([
                'users_id' => Auth::user()->id,
                'tours_id' => $tours['id'],
                'transactions_id' => $tours['id'],
                'quantity' => $tours['quantity']
            ]);
        }

        return ResponseFormatter::success($transaction->load('items.tours'), 'Transaksi berhasil');
    }
}
