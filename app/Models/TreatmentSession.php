<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentSession extends Model
{
    //
    use HasFactory;
    protected $fillable = ['patient_id', 'therapist_id', 'session_date', 'status','patient_photo_path', 'visit_number'];
    public function patient(){
        return $this->belongsTo(Patient::class);
    }
    // File: app/Models/TreatmentSession.php
public function medicalRecord()
{
    return $this->hasOne(MedicalRecord::class);
}
public function therapist()
{
    return $this->belongsTo(User::class, 'therapist_id');
}
}
