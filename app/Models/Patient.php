<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];
    public function treatmentSessions()
{
    return $this->hasMany(TreatmentSession::class);
}
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    protected function name(): Attribute
    {
        return Attribute::make(
            // Fungsi 'set' ini akan berjalan setiap kali Anda mencoba menyimpan nama
            set: fn (string $value) => ucwords(strtolower($value)),
        );
    }
}