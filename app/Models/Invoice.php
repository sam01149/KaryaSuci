<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    // File: app/Models/Invoice.php
    protected $fillable = ['treatment_session_id', 'patient_id', 'cashier_id', 'amount', 'payment_type','receipt_photo_path'];
    public function patient()
{
    return $this->belongsTo(Patient::class);
}

public function cashier()
{
    return $this->belongsTo(User::class, 'cashier_id');
}
public function productSale()
{
    return $this->belongsTo(ProductSale::class, 'product_sale_id');
}
}
