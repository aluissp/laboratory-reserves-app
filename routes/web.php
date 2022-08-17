<?php

use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController as Admin;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', fn () => auth()->check() ? route('home') : view('welcome'));

Auth::routes();

Route::middleware(['auth'])->group(function () {
  Route::get('/home', [HomeController::class, 'index'])->name('home');

  $role = config('role.admin');
  Route::resource('majors', MajorController::class)->except('create', 'show', 'edit')->middleware("role:{$role}");
});
