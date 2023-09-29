<?php

use App\Http\Controllers\FacebookController;
use App\Http\Controllers\GithubController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get( '/', function () {
    return view( 'welcome' );
} );


Route::middleware( [
    'auth:sanctum',
    config( 'jetstream.auth_session' ),
    'verified',
] )->group( function () {
    Route::get( '/dashboard', function () {
        return view( 'dashboard' );
    } )->name( 'dashboard' );
} );

Route::prefix( '/auth' )->group( function () {
    Route::get( '/github/redirect', [ GithubController::class, 'redirect' ] );
    Route::get( '/github/callback', [ GithubController::class, 'callback' ] );

    Route::get( '/facebook/redirect', [ FacebookController::class, 'redirect' ] );
    Route::get( '/facebook/callback', [ FacebookController::class, 'callback' ] );
} );
