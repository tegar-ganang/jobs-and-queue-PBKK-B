<?php

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

Route::get('contohJobs', function () {
    dispatch(new App\Jobs\contohJob);
});

Route::get('common', function () {
    dispatch(new App\Jobs\commonJob);
});

Route::get('error', function () {
    dispatch(new App\Jobs\errorJob);
});

Route::get('delay', function () {
    dispatch(new App\Jobs\delayJob);
});

Route::get('langsungcommon', function () {
    dispatch_sync(new App\Jobs\commonJob);
});

Route::get('langsungerror', function () {
    dispatch_sync(new App\Jobs\errorJob);
});

Route::get('langsungdelay', function () {
    dispatch_sync(new App\Jobs\delayJob);
});

Route::get('alljob', function () {
    dispatch(new App\Jobs\commonJob);
    dispatch(new App\Jobs\errorJob)->onQueue('high');
    dispatch(new App\Jobs\delayJob)->onQueue('low');
});


