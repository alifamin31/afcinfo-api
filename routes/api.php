<?php

use App\Http\Controllers\AFCInfoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/afc_info/register", [AFCInfoController::class, "register"]);
Route::post("/afc_info/login", [AFCInfoController::class, "login"]);
Route::post("/afc_info/register_countries", [AFCInfoController::class, "countries"]);
Route::get("/afc_info/get_countries", [AFCInfoController::class, "getCountries"]);
Route::post("/afc_info/register_players", [AFCInfoController::class, "registerPlayers"]);
Route::post("/afc_info/get_squads", [AFCInfoController::class, "getSquads"]);
