<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailHistory extends Model
{
    use HasFactory;

    protected $table = 'mail_history';
    protected $primaryKey = 'id';
    protected $guarded = array();

    public function patient() {
        return $this->belongsTo(Patients::class, 'patient_id','id');
    }
    public function sent() {
        return $this->belongsTo(User::class, 'sent_by','userid');
    }
    public function modified() {
        return $this->belongsTo(User::class, 'modified_by','userid');
    }

}

