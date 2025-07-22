<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientArrival extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function receptionist()
    {
        return $this->belongsTo(User::class, 'receptionist_id');
    }
}