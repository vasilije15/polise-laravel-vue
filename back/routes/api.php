<?php

use Illuminate\Http\Request;
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

// Login
Route::post('/register', 'Login\LoginController@register');
Route::post('/login', 'Login\LoginController@login');


Route::group(['middleware' => ['auth:api']], function () {

    // Polise
    Route::post('/insuranceCards', 'InsuranceCard\InsuranceCardController@store');

    Route::get('/cards', 'InsuranceCard\InsuranceCardController@index');
    Route::get('/insuranceCards/{insuranceCard}', 'InsuranceCard\InsuranceCardController@show');

    Route::get('/cardsInNextDays', 'InsuranceCard\InsuranceCardController@getCardsInNextDays');
    Route::get('/cardsInNext/{days}', 'InsuranceCard\InsuranceCardController@getCardsInNext');

    // Ugovornik osiguranja
    Route::get('/contractors', 'InsuranceCard\InsuranceCardController@getContractors');
    Route::get('/contractors/{contractor}', 'InsuranceCard\InsuranceCardController@getContractor');

    // Osiguranici
    Route::get('/insureds', 'InsuranceCard\InsuranceCardController@getInsureds');
    Route::get('/insureds/{insured}', 'InsuranceCard\InsuranceCardController@getInsured');

    // Vozila
    Route::get('/cars', 'InsuranceCard\InsuranceCardController@getCars');


    // Statistika
    Route::get('/cardsFromThisYear', 'InsuranceCard\InsuranceCardController@getStatsFromCurrentYear');
    Route::get('/cardsFrom/{year}', 'InsuranceCard\InsuranceCardController@getStatsFromYear');

    Route::get('/tax', 'InsuranceCard\InsuranceCardController@getTaxFromCurrentYear');
    Route::get('/totalCollected', 'InsuranceCard\InsuranceCardController@getTotalCollectedFromCurrentYear');
    Route::get('/totalCards', 'InsuranceCard\InsuranceCardController@getTotalCardsFromCurrentYear');

    Route::get('/tax/{year}', 'InsuranceCard\InsuranceCardController@getTaxFromYear');
    Route::get('/totalCollected/{year}', 'InsuranceCard\InsuranceCardController@getTotalCollectedFromYear');
    Route::get('/totalCards/{year}', 'InsuranceCard\InsuranceCardController@getTotalCardsFromYear');

});

Route::fallback(function(){
    return response()->json([
        'message' => 'Route not found'], 404);
});






