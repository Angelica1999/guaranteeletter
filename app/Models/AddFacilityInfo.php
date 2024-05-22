<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddFacilityInfo extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'addfacilityinfo';
    protected $guarded = array();

    public function facility() {   
        return $this->belongsTo(Facility::class, 'facility_id','id');
    }
}
