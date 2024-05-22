<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;

    protected $table = 'patients';
    protected $guarded = array();
    
    public function group() {
        return $this->belongsTo(Group::class, 'group_id', 'id');
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

    public function encoded_by() {       
        return $this->belongsTo(User::class, 'created_by','userid');
    }

    public function fundSource() {       
        return $this->belongsTo(Fundsource::class, 'fundsource_id','id');
    }

    public function proponentData() {       
        return $this->belongsTo(Proponent::class, 'proponent_id','id');
    }
    
}
