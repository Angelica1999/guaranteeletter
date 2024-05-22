<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilization extends Model
{
    use HasFactory;

    protected $table = 'utilization';
    protected $guarded = array();

    public function proponentdata(){
        return $this->belongsTo(Proponent::class, 'proponent_id', 'id');
    }

    public function fundSourcedata(){
        return $this->belongsTo(FundSource::class, 'fundsource_id', 'id');
    }
    // public function facility() {   
    //     return $this->belongsTo(Facility::class, 'facility_id','id');
    // }
    public function facilitydata() {   
        return $this->belongsTo(Facility::class, 'facility_id','id');
    }
    public function user() {   
        return $this->belongsTo(User::class, 'created_by','userid');
    }
    public function user_budget() {   
        return $this->belongsTo(User::class, 'obligated_by','userid');
    }
    public function transfer() {   
        return $this->belongsTo(Transfer::class, 'transfer_id','id');
    }

}
