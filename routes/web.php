<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.index');
});

Route::get('/home', function () {
    return view('home.index');
})->name('home');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/register/student', [AuthController::class, 'showRegisterStudent'])->name('register.student');
Route::get('/register/organizer', [AuthController::class, 'showRegisterOrganizer'])->name('register.organizer');

// Role-specific login pages
Route::get('/login/student', [AuthController::class, 'showStudentLogin'])->name('login.student');
Route::post('/login/student', [AuthController::class, 'loginStudent']);

Route::get('/login/organizer', [AuthController::class, 'showOrganizerLogin'])->name('login.organizer');
Route::post('/login/organizer', [AuthController::class, 'loginOrganizer']);

Route::get('/login/admin', [AuthController::class, 'showAdminLogin'])->name('login.admin');
Route::post('/login/admin', [AuthController::class, 'loginAdmin']);

// Backward compatible route (defaults to student login page)
Route::get('/login', [AuthController::class, 'showStudentLogin'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Profile
use App\Http\Controllers\ProfileController;
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
Route::post('/events', [EventController::class, 'store'])->name('events.store');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/events/{event}/register', [RegistrationController::class, 'create'])->name('registrations.create');
Route::post('/events/{event}/register', [RegistrationController::class, 'store'])->name('registrations.store');

Route::post('/registrations/{registration}/approve', [RegistrationController::class, 'approve'])->name('registrations.approve');
Route::post('/registrations/{registration}/reject', [RegistrationController::class, 'reject'])->name('registrations.reject');

Route::get('/admin/events/pending', [EventController::class, 'pendingApproval'])->name('admin.events.pending');
Route::post('/admin/events/{event}/approve', [EventController::class, 'approve'])->name('admin.events.approve');
Route::post('/admin/events/{event}/reject', [EventController::class, 'reject'])->name('admin.events.reject');

Route::get('/clubs', [ClubController::class, 'index'])->name('clubs.index');
