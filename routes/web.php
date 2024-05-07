<?php

use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
	return view('welcome');
});

// Route::view('dashboard', 'dashboard')

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'verified']);

Route::view('home', 'home')
	->name('home')
	->middleware(['auth', 'verified']);

Route::middleware(['web', 'auth'])->group(function () {
	Route::get('/profile', [ProfileController::class, 'editProfile'])->name('profile');
	Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
	Route::delete('/profile/avatar', [ProfileController::class, 'removeOldAvatar'])->name('profile.deleteavatar');
	Route::delete('/profile/device/{id}', [ProfileController::class, 'removeDevice'])->name('profile.deletedevice');
	Route::get('/checkout/{plan:code}/{payment_method}', [CheckoutController::class, 'index'])->name('checkout.go');
	Route::get('/verify/{payment:payment_code}/{payment_method}', [CheckoutController::class, 'verify'])->name('checkout.verify');
});

Route::middleware(['auth', 'can:is-admin'])->group(function () {

	Route::resource('pengguna', PenggunaController::class);
	Route::resource('plan', PlanController::class);
	Route::put('pengguna/{user}/update_keahlian', [PenggunaController::class, 'update_keahlian'])->name('pengguna.update_keahlian');
	Route::put('pengguna/{user}/tambah_bayaran', [PenggunaController::class, 'tambah_bayaran'])->name('pengguna.tambah_bayaran');

});