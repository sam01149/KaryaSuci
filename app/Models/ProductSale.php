<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    //
    protected $fillable = [
    'patient_id', 
    'cashier_id', 
    'product_type', 
    'product_name', 
    'quantity', 
    'total_price'
    
];
protected $guarded = ['id'];
public function patient()
    {
        // Relasi 'belongsTo' digunakan karena tabel 'product_sales'
        // memiliki 'patient_id'.
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    /**
     * Mendefinisikan relasi bahwa satu ProductSale dicatat oleh satu Cashier (User).
     * Saya asumsikan model kasir Anda adalah User. Ganti jika namanya berbeda.
     */
    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }
}
