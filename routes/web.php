<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// Import semua controller Anda di sini
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Cashier\SaleController; 
use App\Http\Controllers\CashierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\Auth\CustomPasswordResetController;
use App\Http\Controllers\TransactionReportController;
use App\Http\Controllers\TreatmentSessionController;
use App\Http\Controllers\ActivityLogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTE PUBLIK (UNTUK PENGGUNA YANG BELUM LOGIN) ---
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('lupa-password', [CustomPasswordResetController::class, 'showRequestForm'])->name('password.customRequestForm');
    Route::post('lupa-password', [CustomPasswordResetController::class, 'sendResetRequest'])->name('password.customSendRequest');
});


// --- RUTE YANG MEMERLUKAN LOGIN ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Rute Dasbor Utama yang "Pintar"
    Route::get('/dashboard', function () {
        if (in_array(Auth::user()->role, ['Admin', 'Manajer'])) {
            return redirect()->route('manager.dashboard');
        }
        
        $date = Carbon::now();
        $daysInMonth = $date->daysInMonth;
        $startOfMonth = $date->copy()->startOfMonth()->dayOfWeek;
        $monthName = $date->locale('id')->translatedFormat('F Y');
        return view('dashboard', compact('daysInMonth', 'startOfMonth', 'monthName'));
    })->name('dashboard');
    
    // Rute Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Rute Terpusat untuk Resource Utama
    Route::resource('admin/users', UserController::class);
    Route::resource('admin/branches', BranchController::class);
    Route::resource('patients', PatientController::class);
    Route::get('/patients-archive', [PatientController::class, 'archive'])->name('patients.archive');
    Route::post('patients/{patient}/checkin', [PatientController::class, 'checkin'])->name('patients.checkin');
    Route::get('patients/{patient}/cetak', [PatientController::class, 'printPDF'])->name('patients.print.pdf'); // <-- RUTE BARU
    Route::get('/patients/{patient}/detail', [PatientController::class, 'detail'])->name('patients.detail');


    
    // Rute Invoice
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::post('/invoices/{invoice}/installments', [InvoiceController::class, 'storeInstallment'])->name('invoices.store_installment');
    // Route::get('/invoices/print', [InvoiceController::class, 'printPDF'])->name('invoices.print'); // Rute Print PDF
    Route::get('/laporan-invoice/cetak', [InvoiceController::class, 'printPDF'])->name('invoices.print.pdf');


    // Rute Umum Lainnya
    Route::get('inbox', [InboxController::class, 'index'])->name('inbox.index');
    Route::get('inbox/{message}', [InboxController::class, 'show'])->name('inbox.show');
    

    // Rute Spesifik per Role
    Route::get('manager/dashboard', [DashboardController::class, 'index'])->name('manager.dashboard');
    Route::get('manager/transactions', [TransactionReportController::class, 'index'])->name('manager.transactions.index');

    Route::prefix('therapist')->name('therapist.')->group(function () {
        Route::get('queue', [TreatmentSessionController::class, 'index'])->name('queue.index');
        Route::get('session/{session}/treat', [TreatmentSessionController::class, 'treat'])->name('session.treat');
        Route::post('session/{session}/finish', [MedicalRecordController::class, 'store'])->name('session.finish');
    });

    Route::prefix('cashier')->name('cashier.')->group(function () {
        Route::get('queue', [CashierController::class, 'index'])->name('queue.index');
        Route::post('session/{session}/pay', [CashierController::class, 'processPayment'])->name('session.pay');
        Route::get('sales/create', [SaleController::class, 'create'])->name('sales.create');
        Route::post('sales', [SaleController::class, 'store'])->name('sales.store');
        Route::post('session/{session}/confirm', [CashierController::class, 'confirmPackageSession'])->name('session.confirm');

    });
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

});

// Baris ini memuat rute login, register, dll. yang standar
require __DIR__.'/auth.php';