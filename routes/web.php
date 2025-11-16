<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvitationController; // pastikan ini ada
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\WishesController; 
use App\Http\Controllers\InviteLandingController; 
use App\Http\Controllers\AdminAuthController; 

Route::get('/', function () {
    return view('frontend.index');
});

// Halaman undangan publik (slug)
Route::get('/u/{invitation:slug}', [InviteLandingController::class, 'show'])
    ->name('invite.show');

// Submit RSVP tamu
Route::post('/u/{invitation:slug}/rsvp', [RsvpController::class, 'storeFromGuest'])
    ->name('invite.rsvp.store');
// Submit Wishes tamu (BARU)
Route::post('/u/{invitation:slug}/wishes', [WishesController::class, 'storeFromGuest'])
    ->name('invite.wishes.store');


// Halaman form login admin
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])
    ->name('admin.login');

// Proses submit login admin
Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.submit');

// Logout admin
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');

// =====================
// AREA ADMIN (TERLINDUNGI)
// =====================
Route::prefix('admin')
    ->name('admin.')
    ->middleware('admin.auth')
    ->group(function () {

        // Resource untuk invitations
        Route::resource('invitations', InvitationController::class)->except(['show']);

        // Live search invitation
        Route::get('invitations/search/live', [InvitationController::class, 'live'])
            ->name('invitations.live');

        // Kehadiran / RSVP
        Route::get('rsvp', [RsvpController::class, 'index'])->name('rsvp.index');
        Route::get('rsvp/live', [RsvpController::class, 'live'])->name('rsvp.live');

        // Ucapan (Read-only list + Live search)
        Route::get('wishes', [WishesController::class, 'index'])->name('wishes.index');
        Route::get('wishes/live', [WishesController::class, 'live'])->name('wishes.live');

        // Akun / profil pengantin (nanti bisa kamu isi sendiri)
        Route::view('/account', 'admin.account')->name('account');
    });


