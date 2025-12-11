<?php

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test-event', function () {
    $user = new \App\Models\User;
    $user->name  = 'Hương';
    $user->email = 'huong@gmail.com';

    event(new App\Events\UserRegistered($user));

    return "Event đã phát! Có tên rồi nè";
});