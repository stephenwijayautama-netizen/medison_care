<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // GET ALL TRANSACTIONS
    public function index()
    {
        $transactions = Transaction::all();

        return response()->json([
            'success' => true,
            'data'    => $transactions
        ]);
    }

    // GET TRANSACTION BY ID
    public function getTransaction($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'transaction not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $transaction
        ]);
    }

    // CREATE TRANSACTION
    public function create(Request $request)
    {
        $credentials = $request->validate([
            'user_id'         => 'required|integer',
            'total_amount'    => 'required|numeric',
            'shipping_cost'   => 'required|numeric',
            'status'          => 'required|string|max:50',
            'payment_method'  => 'required|string|max:50',
            'transaction_date'=> 'required|date',
        ]);

        $transaction = Transaction::create($credentials);

        return response()->json([
            'success' => true,
            'data'    => $transaction
        ]);
    }

    // UPDATE TRANSACTION
    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'transaction not found'], 404);
        }

        $credentials = $request->validate([
            'user_id'         => 'integer',
            'total_amount'    => 'numeric',
            'shipping_cost'   => 'numeric',
            'status'          => 'string|max:50',
            'payment_method'  => 'string|max:50',
            'transaction_date'=> 'date',
        ]);

        $transaction->update($credentials);

        return response()->json([
            'success' => true,
            'data'    => $transaction
        ]);
    }

    // DELETE TRANSACTION
    public function delete($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'transaction not found'], 404);
        }

        $transaction->delete();

        return response()->json([
            'success' => true,
            'message' => 'transaction deleted'
        ]);
    }
}
