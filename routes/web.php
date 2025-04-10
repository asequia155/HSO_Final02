<?php
use App\Http\Middleware\DiscardExpiredReservations;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TransactionHistory;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\PatientDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PrescriptionController;
use Illuminate\Foundation\Application;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredUserController;
use Inertia\Inertia;

Route::get('index', function () {
    return Inertia::render('Index'); // Refers to resources/js/Pages/Index.vue
})->name('index');

// Home route
Route::get('/', function () {


     return view('index', [
        'message' => session('message', null),
        'message_type' => session('message_type', null),
    ]);
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
Route::post('/products/{id}/add-stock', [ProductController::class, 'addStock'])->name('products.addStock');
Route::get('batchList', [BatchController::class, 'index'])->name('batchList.index');
Route::put('/batches/{id}', [BatchController::class, 'update'])->name('batches.update');
Route::delete('/batches/{id}', [BatchController::class, 'deleteBatch'])->name('batches.delete');



Route::get('/api/patients', [PatientController::class, 'search']);

Route::resource('patients', PatientController::class);
Route::get('/patients', [PatientController::class, 'index'])->name('patients');
Route::get('/patients/AddPatient', [PatientController::class, 'create'])->name('patients.create');
Route::get('/patients/{id}', [PatientController::class, 'show'])->name('patients.show');
Route::post('/patients/{id}/prescriptions', [PrescriptionController::class, 'store']);
Route::delete('/patients/{patientId}/prescriptions/{prescriptionId}', [PrescriptionController::class, 'destroy'])->name('prescriptions.destroy');
Route::put('/patients/{patientId}/prescriptions/{prescriptionId}', [PrescriptionController::class, 'update'])->name('prescriptions.update');
Route::get('/patients/{email}', [ReservationController::class, 'show'])->name('patientexist.show');


Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::delete('/notifications/{id}', [NotificationController::class, 'delete'])->name('notifications.delete');
Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');


Route::resource('pos', POSController::class);
Route::resource('categories', CategoryController::class);
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::delete('categories/{id}', [CategoryController::class, 'delete'])->name('categories.delete');

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
    } elseif ($user->hasRole('patient')) {
        return redirect()->route('patient.dashboard');
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

Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/patient/dashboard', [DashboardController::class, 'patientDashboard'])->name('patient.dashboard');
});

Route::resource('reservations', ReservationController::class)->only([
    'index', 'store', 'destroy'
]);
Route::post('/reservations/{id}/reject', [ReservationController::class, 'delete'])->name('reservations.reject');

Route::post('/reservations/{id}/confirm', [ReservationController::class, 'confirm'])->name('reservations.confirm');
Route::post('/api/reservations/confirm', [ReservationController::class, 'confirmReservation']);
Route::post('/confirm-reservation', [ReservationController::class, 'confirmReservation'])
    ->name('reservations.confirm');
Route::get('/ReservationForm', function () {
    return Inertia::render('ReservationForm'); // Match the component's location and name
})->name('ReservationForm');

Route::middleware([DiscardExpiredReservations::class])->group(function () {
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
});

Route::post('/api/confirm-reservation', [ReservationController::class, 'confirmReservation']);
Route::get('/user', [PatientDashboardController::class, 'index'])->name('user.reservations.index'); //patient/user
Route::get('/user/history', [PatientDashboardController::class, 'history'])->name(name: 'user.reservations.history'); // patient/user
Route::get('/user/apply-reservation', action: [PatientDashboardController::class, 'applyReservation'])->name(name: 'user.applyReservation'); // patient/apply reservation
Route::post('/user/apply-reservation/store', action: [PatientDashboardController::class, 'store'])->name(name: 'user.applyReservation.store'); // patient/apply reservation

Route::get('/user/purchase', action: [PatientDashboardController::class, 'purchase'])->name(name: 'user.purchase'); // patient/apply reservation




Route::middleware(['auth'])->group(function () {
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
});
Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
Route::get('/reservations/slots', [ReservationController::class, 'getAvailableSlots'])->name('reservations.slots');

Route::get('/reservations/new/count', [ReservationController::class, 'newCount'])->name('reservations.new.count');
Route::post('/reservations/mark-viewed', [ReservationController::class, 'markViewed'])->name('reservations.mark.viewed');
Route::post('/reservations/reset-new', [ReservationController::class, 'resetNewCount'])->name('reservations.reset.new');
Route::middleware(['auth'])->group(function () {
    Route::get('/reservations/history', action: [ReservationController::class, 'history'])->name('reservations.history');
});

Route::get('/reservations/count', [ReservationController::class, 'reservationCount'])->name('reservations.count');



Route::get('/reservations/holidays', [ReservationController::class, 'holidayIndex'])->name('reservations.index');

Route::get('/reservations/holidays', [ReservationController::class, 'holidayIndex'])->name('reservations.holidayIndex');
Route::get('/reservations/holidays/fetch', [ReservationController::class, 'fetchHolidays'])->name('reservations.fetchHolidays');
Route::post('/reservations/holidays', [ReservationController::class, 'storeHoliday'])->name('reservations.storeHoliday');
Route::delete('/reservations/holidays/{holiday}', [ReservationController::class, 'destroyHoliday'])->name('reservations.destroyHoliday');
// Include authentication routes
Route::put('/accounts/{id}', [AccountController::class, 'update'])->name('accounts.update');
Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
Route::post('/accounts/{id}/toggle-active', [AccountController::class, 'toggleActive'])->name('accounts.toggleActive');
Route::delete('/accounts/{id}', [AccountController::class, 'destroy'])->name('accounts.destroy');
Route::get('/accounts/add-clerk', function () {
    return Inertia::render('Frontend/Accounts/RegistrationModal');
})->name('accounts.store1');
require __DIR__.'/auth.php';
