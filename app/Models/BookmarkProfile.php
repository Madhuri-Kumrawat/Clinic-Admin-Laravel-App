<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookmarkProfile extends Model {

    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = "clinic_bookmark_profile";
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];   
}
