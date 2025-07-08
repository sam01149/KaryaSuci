<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'contact_number',
        'address',
        'date_of_birth',
        'gender',
        'medical_history_summary',
        'program_status',
        'program_proof_photo_path' // Kita tambahkan ini juga untuk nanti
    ];
    public function treatmentSessions()
{
    return $this->hasMany(TreatmentSession::class);
}
}