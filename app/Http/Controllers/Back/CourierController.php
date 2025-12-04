<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    // GET ALL COURIER
    public function index()
    {
        $couriers = Courier::all();

        return response()->json([
            'success' => true,
            'data' => $couriers
        ]);
    }

    // GET COURIER BY ID
    public function getCourier($id)
    {
        $courier = Courier::find($id);

        if (!$courier) {
            return response()->json(['message' => 'courier not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $courier
        ]);
    }

    // CREATE COURIER
    public function create(Request $request)
    {
        $credentials = $request->validate([
            'name'  => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $courier = Courier::create($credentials);

        return response()->json([
            'success' => true,
            'data' => $courier
        ]);
    }

    // UPDATE COURIER
    public function update(Request $request, $id)
    {
        $courier = Courier::find($id);

        if (!$courier) {
            return response()->json(['message' => 'courier not found'], 404);
        }

        $credentials = $request->validate([
            'name'  => 'string|max:255',
            'description' => 'nullable|string',
        ]);

        $courier->update($credentials);

        return response()->json([
            'success' => true,
            'data' => $courier
        ]);
    }

    // DELETE COURIER
    public function delete($id)
    {
        $courier = Courier::find($id);

        if (!$courier) {
            return response()->json(['message' => 'courier not found'], 404);
        }

        $courier->delete();

        return response()->json([
            'success' => true,
            'message' => 'courier deleted'
        ]);
    }
}
