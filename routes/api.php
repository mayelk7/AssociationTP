<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| API publique - Lecture seule
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {
    Route::get('/domaines',                       [ApiController::class, 'domaines']);
    Route::get('/domaines/{id}/associations',     [ApiController::class, 'associationsByDomaine']);
    Route::get('/associations',                   [ApiController::class, 'associations']);
    Route::get('/associations/{id}',              [ApiController::class, 'association']);
    Route::get('/emails',                         [ApiController::class, 'emails']);
});
