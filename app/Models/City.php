<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class City extends Model {

    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = "clinic_city";
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    /**
     * Retrieve All users according to Filter Params
     *
     * @param  string  $token
     * @return Users 
     */
    public static function city_xhr($filter = "", $limit = RECORD_LIMIT_10K, $skip = 0, $order = array("`clinic_city`.`created_at`" => "DESC")) {
        $results = DB::select('select clinic_city.*'
                        . ' FROM `clinic_city` '
                        . ' WHERE ' . $filter . ' order by ' . array_keys($order)[0] . ' ' . array_values($order)[0] . ' LIMIT ' . $skip . ', ' . $limit);
        return $results;
    }

    /**
     * Retrieve users Count according to Filter Params
     *
     * @param  string  $token
     * @return Users  Count
     */
    public static function city_xhr_count($filter = "") {
        $results = DB::select('select count(clinic_city.id) as total'
                        . ' FROM `clinic_city` '
                        . ' WHERE ' . $filter );
        return (sizeof($results)>0)?$results[0]->total:0;
    }

}
