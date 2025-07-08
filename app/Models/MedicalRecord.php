<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class MedicalRecord extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'treatment_session_id',
        'patient_id',
        'therapist_id',
        'assessment',
        'diagnosis',
        'treatment_plan'
    ];
}
