<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class Review extends Model {

    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = "clinic_review";
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    /**
     * Retrieve All reviews according to Filter Params
     *
     * @param  string  $token
     * @return Reviews 
     */
    public static function review_xhr($filter = "", $limit = RECORD_LIMIT_10K, $skip = 0, $order = array("`clinic_review`.`created_at`" => "DESC")) {
        $results = DB::select('select clinic_review.*,`clinic_profile`.`name` as profile_name,`clinic_profile`.`specialist_type`,`users`.`name` as user_name'
                        . ' FROM `clinic_review` '
                        . ' JOIN `clinic_profile` ON `clinic_profile`.`id`=`clinic_review`.`profile_id` '
                        . ' JOIN `users` ON `users`.`id`=`clinic_review`.`user_id` '                      
                        . ' WHERE ' . $filter . ' order by ' . array_keys($order)[0] . ' ' . array_values($order)[0] . ' LIMIT ' . $skip . ', ' . $limit);
        return $results;
    }

    /**
     * Retrieve reviews Count according to Filter Params
     *
     * @param  string  $token
     * @return Reviews  Count
     */
    public static function review_xhr_count($filter = "") {
        $results = DB::select('select count(clinic_review.id) as total'
                        . ' FROM `clinic_review` '
                        . ' JOIN `clinic_profile` ON `clinic_profile`.`id`=`clinic_review`.`profile_id` '
                        . ' JOIN `users` ON `users`.`id`=`clinic_review`.`user_id` '
                        . ' WHERE ' . $filter );
        return (sizeof($results)>0)?$results[0]->total:0;
    }

}
