<?php

use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController as Admin;
use App\Http\Controllers\Admin\RoleController;
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

Route::get('/', fn () => auth()->check() ? redirect()->route('home') : view('welcome'));

Auth::routes();

Route::middleware(['auth'])->group(function () {
  Route::get('/home', [HomeController::class, 'index'])->name('home');

  $role = config('role.admin');
  Route::resource('majors', MajorController::class)
    ->except('create', 'show', 'edit')
    ->middleware("role:{$role}");

  Route::get('/majors/{filter}/filter', [MajorController::class, 'filter'])
    ->name('majors.filter')->middleware("role:{$role}");

  Route::resource('roles', RoleController::class)
    ->except('create', 'show', 'edit')
    ->middleware("role:{$role}");

  Route::resource('users', Admin::class)
    ->except('show', 'store', 'create')
    ->middleware("role:{$role}");

  Route::get('/users/{filter}/filter', [Admin::class, 'filter'])
    ->name('users.filter')
    ->middleware("role:{$role}");
});
