<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class Profile extends Model {

    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = "clinic_profile";
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    /**
     * Retrieve All Specialist according to Filter Params
     *
     * @param  string  $token
     * @return Specialist 
     */
    public static function profile_xhr($filter = "", $limit = RECORD_LIMIT_10K, $skip = 0, $order = array("`clinic_profile`.`created_at`" => "DESC")) {
        $results = DB::select('select clinic_profile.*,`clinic_specialist`.`name` as specialist_name'
                        . ' FROM `clinic_profile` '
                        . ' LEFT JOIN `clinic_specialist` ON `clinic_specialist`.`id`= `clinic_profile`.`specialist_id` AND `clinic_specialist`.`deleted_at` IS NULL '
                        . ' WHERE ' . $filter . ' order by ' . array_keys($order)[0] . ' ' . array_values($order)[0] . ' LIMIT ' . $skip . ', ' . $limit);
        return $results;
    }

    /**
     * Retrieve Specialist Count according to Filter Params
     *
     * @param  string  $token
     * @return Specialist  Count
     */
    public static function profile_xhr_count($filter = "") {
        $results = DB::select('select count(clinic_profile.id) as total'
                        . ' FROM `clinic_profile` '
                        . ' LEFT JOIN `clinic_specialist` ON `clinic_specialist`.`id`= `clinic_profile`.`specialist_id` AND `clinic_specialist`.`deleted_at` IS NULL '
                        . ' WHERE ' . $filter );
        return (sizeof($results)>0)?$results[0]->total:0;
    }

}
