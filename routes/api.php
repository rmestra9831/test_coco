<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PokemonController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('securePokemonApi')->group(function () {
    Route::get('/getPokemons', 'PokemonController@getPokemons');
    Route::get('/getPokemonsSlow', 'PokemonController@getPokemonsSlow');
    Route::get('/searchPokemon', 'PokemonController@searchPokemon');
    Route::get('/sendAnyData', 'PokemonController@sendAnyData');
});
