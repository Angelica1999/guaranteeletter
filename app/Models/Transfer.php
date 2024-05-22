<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $table = 'transfer';
    protected $pimaryKey = 'id';

    public function from_fundsource(){
        return $this->belongsTo(Fundsource::class, 'from_saa','id');
    }
    public function to_fundsource(){
        return $this->belongsTo(Fundsource::class, 'to_saa','id');
    }
    public function to_facilityInfo() {
        return $this->belongsTo(Facility::class, 'to_facility','id');
    }
    public function from_facilityInfo() {
        return $this->belongsTo(Facility::class, 'from_facility','id');
    }
    public function to_proponentInfo() {
        return $this->belongsTo(Proponent::class, 'to_proponent','id');
    }
    public function from_proponentInfo() {
        return $this->belongsTo(Proponent::class, 'from_proponent','id');
    }

}
