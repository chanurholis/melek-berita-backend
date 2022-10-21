<?php

use App\Http\Controllers\Football\Standings\WorldCupStandingAction;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return 'Backend Melek Berita V1';
});

Route::get('/debug', function () {
    $dataSource = 'https://data.bmkg.go.id/DataMKG/TEWS/autogempa.xml';
    $xmlString = file_get_contents($dataSource);
    $xmlObject = simplexml_load_string($xmlString);
    $json = json_encode($xmlObject);
    $phpArray = json_decode($json, true);
    return $phpArray;
});

Route::prefix('football')->group(function () {
    Route::prefix('standings')->group(function () {
        Route::get('world-cup', WorldCupStandingAction::class);
    });
});