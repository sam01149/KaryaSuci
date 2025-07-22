<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are not mass assignable.
     * Menggunakan $guarded adalah cara yang baik untuk mengizinkan semua field lain diisi.
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * Relasi ke model Patient.
     * Satu invoice dimiliki oleh satu pasien.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Relasi ke model User (Kasir).
     * Satu invoice dibuat oleh satu kasir.
     */
    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    /**
     * Relasi ke model Sale.
     * Satu invoice bisa berasal dari satu transaksi penjualan produk.
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Relasi ke model TreatmentSession.
     * Satu invoice bisa berasal dari satu sesi perawatan.
     */
    public function treatmentSession()
    {
        return $this->belongsTo(TreatmentSession::class);
    }
    public function branch()
{
    return $this->belongsTo(Branch::class);
}
public function installmentPayments()
{
    return $this->hasMany(InstallmentPayment::class)->latest();
}
}   