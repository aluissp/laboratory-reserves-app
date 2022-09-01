<?php

use App\Http\Controllers\Admin\LabController;
use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\User\ReservationController as UserReservation;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController as Admin;
use App\Http\Controllers\User\UserController as User;
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

  Route::middleware("role:{$role}")->group(function () {
    Route::resource('majors', MajorController::class)
      ->except('create', 'show', 'edit');

    Route::get('/majors/{filter}/filter', [MajorController::class, 'filter'])
      ->name('majors.filter');

    Route::resource('roles', RoleController::class)
      ->except('create', 'show', 'edit');

    Route::resource('users', Admin::class)
      ->except('show', 'store', 'create');

    Route::get('/users/{filter}/filter', [Admin::class, 'filter'])
      ->name('users.filter');

    // Laboratorios
    Route::resource('labs', LabController::class)
      ->except('show');

    Route::get('/labs/{filter}/filter', [LabController::class, 'filter'])
      ->name('labs.filter');

    Route::get('/reservations-all', [ReservationController::class, 'showAll'])
      ->name('reservation.all');
  });

  Route::delete('/reservations/{reservation}/delete', [ReservationController::class, 'delete'])
    ->name('reservation.delete');

  Route::get('/reservations/{filter}/filter', [ReservationController::class, 'filter'])
    ->name('reservations.filter');

  Route::resource('reservations', ReservationController::class)
    ->except('create', 'edit');

  Route::resource('my-reserve', UserReservation::class)
    ->except('create', 'store', 'edit', 'update');

  Route::get('/my-profile/{user}/edit', [User::class, 'edit'])->name('profile.edit');
});
