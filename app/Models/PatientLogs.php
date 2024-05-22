<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientLogs extends Model
{
    use HasFactory;

    protected $table = 'patient_logs';
    protected $primaryKey = 'id';
    protected $guarded = array();

    public function patient() {
        return $this->belongsTo(Patients::class, 'patient_id','id');
    }
    public function modified() {
        return $this->belongsTo(User::class, 'created_by','userid');
    }
    public function facility() {
        return $this->belongsTo(Facility::class, 'facility_id','id');
    }

    public function province() {       
        return $this->belongsTo(Province::class, 'province_id','id');
    }

    public function muncity() {       
        return $this->belongsTo(Muncity::class, 'muncity_id','id');
    }

    public function barangay() {       
        return $this->belongsTo(Barangay::class, 'barangay_id','id');
    }
    public function proponent() {       
        return $this->belongsTo(Proponent::class, 'proponent_id','id');
    }

}

