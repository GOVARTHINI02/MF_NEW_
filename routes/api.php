<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MFController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('new', [MFController::class,'new']);
// 
// Route::get('new', function(Request $request) {
//     return 'hi';
// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
