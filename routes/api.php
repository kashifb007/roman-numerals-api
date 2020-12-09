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
/**
 * To test and not persist in DB
 */
Route::get('/convert/test/{number}', 'ConversionController@displayConversion');

/**
 * Endpoint 1
 * To store a conversion
 * Could have used a POST but would then have to test using POSTMAN
 */
Route::get('/convert/{number}', 'ConversionController@convert')->where('number', '^[1-9][0-9]*$')
    ->name('conversions.create');

/**
 * Endpoint 2
 * 10 at a time starting from newest entries
 */
Route::get('/convert/list', 'ConversionController@displayConversionList')
    ->name('conversions.get');

/**
 * Endpoint 3
 * The top 10 converted integers
 */
Route::get('/convert/top', 'ConversionController@displayTopTen');
