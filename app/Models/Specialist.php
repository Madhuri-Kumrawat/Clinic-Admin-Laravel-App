<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class Specialist extends Model {

    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = "clinic_specialist";
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    /**
     * Retrieve All Specialist according to Filter Params
     *
     * @param  string  $token
     * @return Specialist 
     */
    public static function specialists_xhr($filter = "", $limit = RECORD_LIMIT_10K, $skip = 0, $order = array("`clinic_specialist`.`created_at`" => "DESC")) {
        $results = DB::select('select clinic_specialist.*'
                        . ' FROM `clinic_specialist` '
                        . ' WHERE ' . $filter . ' order by ' . array_keys($order)[0] . ' ' . array_values($order)[0] . ' LIMIT ' . $skip . ', ' . $limit);
        return $results;
    }

    /**
     * Retrieve Specialist Count according to Filter Params
     *
     * @param  string  $token
     * @return Specialist  Count
     */
    public static function specialists_xhr_count($filter = "") {
        $results = DB::select('select count(clinic_specialist.id) as total'
                        . ' FROM `clinic_specialist` '
                        . ' WHERE ' . $filter );
        return (sizeof($results)>0)?$results[0]->total:0;
    }

}
