<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // GET ALL USERS
    public function index()
    {
        $users = User::all();

        return response()->json([
            'success' => true,
            'data'    => $users
        ]);
    }

    // GET USER BY ID
    public function getUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $user
        ]);
    }

    // CREATE USER
    public function create(Request $request)
    {
        $credentials = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|unique:users,email',
            'role_id'   => 'required|integer',
            'password'  => 'required|string|min:6',
            'image'     => 'nullable|string',
            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string',
        ]);

        // encrypt password
        $credentials['password'] = Hash::make($credentials['password']);

        $user = User::create($credentials);

        return response()->json([
            'success' => true,
            'data'    => $user
        ]);
    }

    // UPDATE USER
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }

        $credentials = $request->validate([
            'name'      => 'string|max:255',
            'email'     => 'string|email|unique:users,email,' . $id,
            'role_id'   => 'integer',
            'password'  => 'nullable|string|min:6',
            'image'     => 'nullable|string',
            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string',
        ]);

        if (isset($credentials['password'])) {
            $credentials['password'] = Hash::make($credentials['password']);
        }

        $user->update($credentials);

        return response()->json([
            'success' => true,
            'data'    => $user
        ]);
    }

    // DELETE USER
    public function delete($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'user deleted'
        ]);
    }
}
