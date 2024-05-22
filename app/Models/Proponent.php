<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proponent extends Model
{
    use HasFactory;

    protected $table = 'proponent';
    protected $guarded = array();

    public function fundsource()
    {
        return $this->hasOne(Fundsource::class,'id','fundsource_id');
    }

    public function proponentInfo()
    {
        return $this->hasMany(ProponentInfo::class);
    }
    
    public function utilization()
    {
        return $this->hasMany(Utilization::class, 'proponentinfo_id', 'id');
    }

}
