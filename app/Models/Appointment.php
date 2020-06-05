<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class Appointment extends Model {

    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = "clinic_appointment";
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];   
}
