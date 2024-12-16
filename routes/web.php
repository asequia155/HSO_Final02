<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TransactionHistory;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PrescriptionController;
use Illuminate\Foundation\Application;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Home route
Route::get('/', function () {
    if (auth()->check()) {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
    return view('index'); // Points to resources/views/index.blade.php
});

// Login page
Route::get('/log-in', function () {
    return Inertia::render('Auth/Login'); // Ensure this points to resources/views/log-in.blade.php
})->name('log-in');



// Handle login
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

// Placeholder route
Route::get('/placeholder', function () {
    return response()->json(['message' => 'This is a placeholder route.']);
})->name('placeholder');

// Resource routes
Route::resource('products', ProductController::class);
Route::get('/products/category', [CategoryController::class, 'index'])->name('products.category');
Route::put('/products/{id}/add-stock', [ProductController::class, 'addStock'])->name('products.addStock');


Route::resource('patients', PatientController::class);
Route::get('/patients', [PatientController::class, 'index'])->name('patients');
Route::get('/patients/AddPatient', [PatientController::class, 'create'])->name('patients.create');
Route::get('/patients/{id}', [PatientController::class, 'show'])->name('patients.show');
Route::post('/patients/{id}/prescriptions', [PrescriptionController::class, 'store']);
Route::delete('/patients/{patientId}/prescriptions/{prescriptionId}', [PrescriptionController::class, 'destroy'])->name('prescriptions.destroy');
Route::put('/patients/{patientId}/prescriptions/{prescriptionId}', [PrescriptionController::class, 'update'])->name('prescriptions.update');


Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

Route::resource('pos', POSController::class);
Route::resource('categories', CategoryController::class);
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/rawboard', [DashboardController::class, 'index'])->name('rawboard');

Route::get('/add-patient', function () {
    return Inertia::render('Frontend/Patient/AddPatients');
})->name('add-patient');

Route::get('/transactions/report', [TransactionHistory::class, 'getTransactionReport'])->name('transactions.report');

// Dashboard routes
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('clerk')) {
        return redirect()->route('clerk.dashboard');
    }
    abort(403, 'Unauthorized');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin-specific routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
});

// Clerk-specific routes
Route::middleware(['auth', 'role:clerk'])->group(function () {
    Route::get('/clerk/dashboard', [DashboardController::class, 'clerkDashboard'])->name('clerk.dashboard');
});

// Include authentication routes
require __DIR__.'/auth.php';
