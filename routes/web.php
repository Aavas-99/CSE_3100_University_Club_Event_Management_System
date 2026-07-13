<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', function () {
    return view('home.index');
})->name('home');

Route::get('/home', function () {
    return view('home.index');
})->name('home');

// Registration
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/register/student', [AuthController::class, 'showRegisterStudent'])->name('register.student');
Route::get('/register/organizer', [AuthController::class, 'showRegisterOrganizer'])->name('register.organizer');

// Login - Main choice page
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// Role-specific login pages
Route::get('/login/student', [AuthController::class, 'showStudentLogin'])->name('login.student');
Route::post('/login/student', [AuthController::class, 'loginStudent']);

Route::get('/login/organizer', [AuthController::class, 'showOrganizerLogin'])->name('login.organizer');
Route::post('/login/organizer', [AuthController::class, 'loginOrganizer']);

Route::get('/login/admin', [AuthController::class, 'showAdminLogin'])->name('login.admin');
Route::post('/login/admin', [AuthController::class, 'loginAdmin']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Profile
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

// Events
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
Route::post('/events', [EventController::class, 'store'])->name('events.store');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Registrations
Route::get('/events/{event}/register', [RegistrationController::class, 'create'])->name('registrations.create');
Route::post('/events/{event}/register', [RegistrationController::class, 'store'])->name('registrations.store');
Route::post('/registrations/{registration}/approve', [RegistrationController::class, 'approve'])->name('registrations.approve');
Route::post('/registrations/{registration}/reject', [RegistrationController::class, 'reject'])->name('registrations.reject');

// Admin Event Approvals
Route::get('/admin/events/pending', [EventController::class, 'pendingApproval'])->name('admin.events.pending');
Route::post('/admin/events/{event}/approve', [EventController::class, 'approve'])->name('admin.events.approve');
Route::post('/admin/events/{event}/reject', [EventController::class, 'reject'])->name('admin.events.reject');

// Clubs
Route::get('/clubs', [ClubController::class, 'index'])->name('clubs.index');

// Tickets (auth required)
Route::middleware(['auth'])->group(function () {
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/download', [TicketController::class, 'download'])->name('tickets.download');
    Route::get('/registrations/{registration}/ticket/download', [RegistrationController::class, 'downloadTicket'])
        ->name('registrations.ticket.download');
});