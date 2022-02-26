<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// A cheating way to generate token, for the sake of the test
Route::get('/tokens/create', function (Request $request) {
    //$token = $request->user()->createToken($request->token_name);
    $token = \App\Models\User::find($request->get('user_id'))->createToken('api_token');

    return ['token' => $token->plainTextToken];
});
