<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model {
    protected $connection = 'dts';
    protected $table = 'section';
    protected $primaryKey = 'id';
}

?>