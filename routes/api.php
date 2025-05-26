<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->group( function () {

    Route::delete("users/delete", [UserController::class, "destroy"]);
    Route::put("users/update", [UserController::class, "update"]);
    Route::get("users/show", [UserController::class, "show"]);
    Route::get("users", [UserController::class, "index"]);

});

Route::middleware('guest')->group( function () {
    Route::post("register", [UserController::class, "store"]);
});
