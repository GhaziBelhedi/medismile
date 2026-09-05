<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Secretary;
use App\Http\Controllers\Patient;
use Illuminate\Support\Facades\Route;

// ─── Public ───────────────────────────────────────────────────────────────────

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Admin / Dentist ──────────────────────────────────────────────────────────

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // Appointments
        Route::resource('appointments', Admin\AppointmentController::class);
        Route::patch('appointments/{appointment}/confirm', [Admin\AppointmentController::class, 'confirm'])->name('appointments.confirm');
        Route::patch('appointments/{appointment}/cancel',  [Admin\AppointmentController::class, 'cancel'])->name('appointments.cancel');

        // Patients (view only)
        Route::get('patients',        [Admin\PatientController::class, 'index'])->name('patients.index');
        Route::get('patients/{patient}', [Admin\PatientController::class, 'show'])->name('patients.show');

        // Notes
        Route::get('patients/{patient}/notes/create', [Admin\NoteController::class, 'create'])->name('notes.create');
        Route::post('patients/{patient}/notes',       [Admin\NoteController::class, 'store'])->name('notes.store');

        // Users (secretaries + admins)
        Route::get('users',                [Admin\UserController::class, 'index'])->name('users.index');
        Route::get('users/create',         [Admin\UserController::class, 'create'])->name('users.create');
        Route::post('users',               [Admin\UserController::class, 'store'])->name('users.store');
        Route::delete('users/{user}',      [Admin\UserController::class, 'destroy'])->name('users.destroy');
    });

// ─── Secretary ────────────────────────────────────────────────────────────────

Route::middleware(['auth', 'role:secretary'])
    ->prefix('secretary')
    ->name('secretary.')
    ->group(function () {

        Route::get('/dashboard', [Secretary\DashboardController::class, 'index'])->name('dashboard');

        // Appointments
        Route::get('appointments',                   [Secretary\AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('appointments/create',            [Secretary\AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('appointments',                  [Secretary\AppointmentController::class, 'store'])->name('appointments.store');
        Route::get('appointments/{appointment}/edit', [Secretary\AppointmentController::class, 'edit'])->name('appointments.edit');
        Route::put('appointments/{appointment}',     [Secretary\AppointmentController::class, 'update'])->name('appointments.update');

        // Patients
        Route::get('patients',         [Secretary\PatientController::class, 'index'])->name('patients.index');
        Route::get('patients/create',  [Secretary\PatientController::class, 'create'])->name('patients.create');
        Route::post('patients',        [Secretary\PatientController::class, 'store'])->name('patients.store');
    });

// ─── Patient ──────────────────────────────────────────────────────────────────

Route::middleware(['auth', 'role:patient'])
    ->prefix('patient')
    ->name('patient.')
    ->group(function () {

        Route::get('/dashboard', [Patient\DashboardController::class, 'index'])->name('dashboard');

        // Appointments
        Route::get('appointments',                        [Patient\AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('appointments/create',                 [Patient\AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('appointments',                       [Patient\AppointmentController::class, 'store'])->name('appointments.store');
        Route::get('appointments/slots',                  [Patient\AppointmentController::class, 'slots'])->name('appointments.slots');
        Route::get('appointments/{appointment}',          [Patient\AppointmentController::class, 'show'])->name('appointments.show');
        Route::patch('appointments/{appointment}/cancel', [Patient\AppointmentController::class, 'cancel'])->name('appointments.cancel');

        // Profile
        Route::get('/profile',  [Patient\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile',  [Patient\ProfileController::class, 'update'])->name('profile.update');
    });
