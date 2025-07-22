<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class InstallmentPayment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function invoice() { return $this->belongsTo(Invoice::class); }
    public function cashier() { return $this->belongsTo(User::class, 'cashier_id'); }
}