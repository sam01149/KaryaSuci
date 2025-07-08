<?php
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TreatmentSessionController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionReportController;
use App\Http\Controllers\ProductSaleController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('manager/transactions', [TransactionReportController::class, 'index'])->name('manager.transactions.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('patients', PatientController::class);
    Route::post('patients/{patient}/checkin',[PatientController::class, 'checkin'])->name('patients.checkin');
    Route::prefix('therapist')->name('therapist.')->group(function () {
        // Halaman Antrian
        Route::get('queue', [TreatmentSessionController::class, 'index'])->name('queue.index');
        // Halaman untuk memulai sesi dan membuat rekam medis
        Route::get('session/{session}/treat', [TreatmentSessionController::class, 'treat'])->name('session.treat');
        // Menyimpan rekam medis dan menyelesaikan sesi
        Route::post('session/{session}/finish', [MedicalRecordController::class, 'store'])->name('session.finish');
    });
    Route::prefix('cashier')->name('cashier.')->group(function () {
        Route::get('queue', [CashierController::class, 'index'])->name('queue.index');
        Route::post('session/{session}/pay', [CashierController::class, 'processPayment'])->name('session.pay');
        Route::get('history', [CashierController::class, 'history'])->name('history.index');
        Route::get('/product-sales', [ProductSaleController::class, 'index']);
        Route::get('product-sales/create', [ProductSaleController::class, 'create'])->name('products.create');
        Route::post('product-sales', [ProductSaleController::class, 'store'])->name('products.store');
    });
    Route::get('manager/dashboard', [DashboardController::class, 'index'])->name('manager.dashboard');

});

require __DIR__.'/auth.php';
