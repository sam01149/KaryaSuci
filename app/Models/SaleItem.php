<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Satu item (SaleItem) dimiliki oleh satu transaksi (Sale)
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}