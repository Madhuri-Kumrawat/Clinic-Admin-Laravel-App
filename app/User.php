<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use DB;

class User extends Authenticatable {

    use Notifiable;

use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','reg_type','reg_id','platform','image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function generateToken() {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }
    
    /**
     * Retrieve All Users according to Filter Params
     *
     * @param  string  $token
     * @return User
     */
    public static function app_users_xhr($filter = "", $limit = RECORD_LIMIT_10K, $skip = 0, $order = array("`users`.`created_at`" => "DESC")) {
        $results = DB::select('select users.*'
            . ' FROM `users` '
            . ' JOIN `role_user` ON `users`.`id`= `role_user`.`user_id` AND `users`.`deleted_at` IS NULL '
            . ' JOIN `roles` ON `roles`.`id` = `role_user`.`role_id` AND `roles`.`name`="user" '
            . ' WHERE ' . $filter . ' order by ' . array_keys($order)[0] . ' ' . array_values($order)[0] . ' LIMIT ' . $skip . ', ' . $limit);
        return $results;
    }
    
    /**
     * Retrieve Users Count according to Filter Params
     *
     * @param  string  $token
     * @return User  Count
     */
    public static function app_users_xhr_count($filter = "") {
        $results = DB::select('select count(users.id) as total'
            . ' FROM `users` '
            . ' JOIN  `role_user` ON `users`.`id`= `role_user`.`user_id` AND `users`.`deleted_at` IS NULL '
            . ' JOIN `roles` ON `roles`.`id` = `role_user`.`role_id` AND `roles`.`name`="user" '
            . ' WHERE ' . $filter );
        return (sizeof($results)>0)?$results[0]->total:0;
    }

}
