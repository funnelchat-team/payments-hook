<?php

use App\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Field API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your card. These routes
| are loaded by the ServiceProvider of your card. You're free to add
| as many additional routes to this file as your card may require.
|
*/

Route::get('/app-params', function (Request $request) {
    $platforms = Platform::select('name', 'name_hook')->get()->toArray();
    $data = [
        'token_user' => auth()->user()->token,
        'app_url' => env("APP_URL"),
        'platforms' => $platforms
    ];
    return response()->json($data);
});
