<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingDetails extends Model{
  protected $connection = "dts";
  protected $table = "tracking_details";
}