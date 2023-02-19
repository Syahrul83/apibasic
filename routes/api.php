<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ApiAuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/hello', function () {
    $data = ['message' => 'hello apa kabar'];
    return response()->json($data, 503);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/quote', QuoteController::class);
    Route::post('logout', [ApiAuthController::class, 'logout'])->name('logout');
    Route::post('fileupload', [FileController::class, 'fileUpload'])->name(
        'fileUpload'
    );
});

Route::post('register', [ApiAuthController::class, 'register'])->name(
    'register'
);
Route::post('login', [ApiAuthController::class, 'login'])->name('login');
