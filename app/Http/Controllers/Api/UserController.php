<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        return response()->json([
            "users" => User::all()
        ], 200);
    }


    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            "message" => "User Stored Successfully!",
            "user" => $user,
        ], 201);
    }


    public function show(Request $request)
    {
        $userId = $request->userId;

        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'message' => "User not found",
            ], 404);
        }

        return response()->json([
            'user' => $user,
        ]);
    }


    public function update(Request $request)
    {
        $userId = $request->userId;

        $userInfo = User::find($userId);

        if(!$userInfo)
        {
            return response()->json([
                "message" => "User Does Not Exist"
            ],  404);
        }

        if(Gate::denies("update-user", $userInfo))
        {
            return response()->json([
                "message" => "Unauthorized"
            ], 403);
        }

        $userInfo->update($request->all("name","email"));

        return response()->json([
            "message" => "User updated Successfully!",
            "user" => $userInfo
        ], 200);
    }


    public function destroy(Request $request)
    {
        $userId = $request->userId;
        if(!$userId)
        {
            return response()->json([
                "message" => "User's id is missing."
            ]);
        }

        $userInfo = User::find($userId);

        if (!$userInfo) {
            return response()->json([
                'message' => "User does not exist",
            ], 404);
        }

        if(Gate::denies("delete-user", $userInfo))
        {
            return response()->json([
                "message" => "Unauthorized"
            ], 403);
        }

        $userInfo->delete();
        return response()->json([
            "message" => "User deleted successfully"
        ]);
    }
}
