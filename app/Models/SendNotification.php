<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class SendNotification extends Model {

    protected $table = "clinic_sendnotification";
    protected $guarded = ['id'];

    /**
     * Retrieve All Notification according to Filter Params
     *
     * @param  string  $token
     * @return Notification array 
     */
    public static function notification_xhr($filter = "", $limit = RECORD_LIMIT_10K, $skip = 0, $order = array("`clinic_sendnotification`.`created_at`" => "DESC")) {
        $results = DB::select('select clinic_sendnotification.*'
                        . ' FROM `clinic_sendnotification` '
                        . ' WHERE ' . $filter . ' order by ' . array_keys($order)[0] . ' ' . array_values($order)[0] . ' LIMIT ' . $skip . ', ' . $limit);
        return $results;
    }

    /**
     * Retrieve Notification Count according to Filter Params
     *
     * @param  string  $token
     * @return Notification  Count
     */
    public static function notification_xhr_count($filter = "") {
        $results = DB::select('select count(clinic_sendnotification.id) as total'
                        . ' FROM `clinic_sendnotification` '
                        . ' WHERE ' . $filter);
        return (sizeof($results) > 0) ? $results[0]->total : 0;
    }

}
