<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fundsource extends Model
{
    use HasFactory;

    protected $table = 'fundsource';
    protected $guarded = array();

    public function facility() {   
        return $this->belongsTo(Facility::class, 'facility_id','id');
    }

    
    public function proponents() {   
        return $this->hasMany(Proponent::class);
    }

    public function encoded_by() {       
        return $this->belongsTo(User::class, 'created_by','userid');
    }

    public function utilization() {   
        return $this->hasMany(Utilization::class, 'fundsource_id', 'id');
    }
    public function dv(){
        return $this->hasmany(Dv::class, 'fundsource_id', 'id');
    }
    public function proponentInfo()
    {
        return $this->hasMany(ProponentInfo::class);
    }

    public function cost_usage() {   
        return $this->hasMany(Admin_Cost::class, 'fundsource_id', 'id');
    }

    public function image() {       
        return $this->belongsTo(Fundsource_Files::class, 'saa','saa_no');
    }
}
