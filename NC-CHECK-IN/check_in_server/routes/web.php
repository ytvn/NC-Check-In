<?php

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
Auth::routes(['register' => false]);

Route::middleware('auth')->group(function(){
    Route::get('/', function(){
        return redirect()->route("statistic");
    });

    Route::prefix("/room")->group(function(){
        Route::get("/", "RoomController@index");
        Route::post("/activate", "RoomController@activate");
        Route::post("/deactivate", "RoomController@deactivate");
        Route::post("/clear", "RoomController@clear");
        
    });

    Route::get("/seat-layout", "SeatController@seatLayout");
    Route::post("/seat-layout/sync", "SeatController@seatLayoutSync");

    Route::get("/statistic", "DashboardController@statistic")->name("statistic");

});