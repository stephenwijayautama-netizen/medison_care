<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    // GET ALL DELIVERIES
    public function index()
    {
        $deliveries = Delivery::all();

        return response()->json([
            'success' => true,
            'data'    => $deliveries
        ]);
    }

    // GET DELIVERY BY ID
    public function getDelivery($id)
    {
        $delivery = Delivery::find($id);

        if (!$delivery) {
            return response()->json(['message' => 'delivery not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $delivery
        ]);
    }

    // CREATE DELIVERY
    public function create(Request $request)
    {
        $credentials = $request->validate([
            'transaction_id'     => 'required|integer',
            'courier_id'         => 'required|integer',
            'tracling_number'    => 'nullable|string|max:255',
            'delivery_address'   => 'required|string|max:255',
            'status'             => 'required|string|max:50',
            'shipped_at'         => 'nullable|date',
            'delivered_at'       => 'nullable|date',
            'notes'              => 'nullable|string',
        ]);

        $delivery = Delivery::create($credentials);

        return response()->json([
            'success' => true,
            'data'    => $delivery
        ]);
    }

    // UPDATE DELIVERY
    public function update(Request $request, $id)
    {
        $delivery = Delivery::find($id);

        if (!$delivery) {
            return response()->json(['message' => 'delivery not found'], 404);
        }

        $credentials = $request->validate([
            'transaction_id'     => 'integer',
            'courier_id'         => 'integer',
            'tracling_number'    => 'string|max:255',
            'delivery_address'   => 'string|max:255',
            'status'             => 'string|max:50',
            'shipped_at'         => 'date',
            'delivered_at'       => 'date',
            'notes'              => 'nullable|string',
        ]);

        $delivery->update($credentials);

        return response()->json([
            'success' => true,
            'data'    => $delivery
        ]);
    }

    // DELETE DELIVERY
    public function delete($id)
    {
        $delivery = Delivery::find($id);

        if (!$delivery) {
            return response()->json(['message' => 'delivery not found'], 404);
        }

        $delivery->delete();

        return response()->json([
            'success' => true,
            'message' => 'delivery deleted'
        ]);
    }
}
