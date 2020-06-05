<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model {
    protected $table = "clinic_notification";
    protected $guarded = ['id'];
}
