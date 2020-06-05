<?php

namespace App\Libraries;

use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\{
    Hash,
    Crypt,
    Config
};
use DB;
use \App\Models\Specialist;


class CommonFunctions {

    /**
     * Fetch All States
     *
     * @param  string|null  
     * @return HTML State Option Box
     */
    public static function getColumnEnumValues($table = null, $column = null) {
        $enums = app("db")->table("INFORMATION_SCHEMA.COLUMNS")
                ->select("COLUMN_TYPE")
                ->where('TABLE_NAME', $table)
                ->where('COLUMN_NAME', $column)
                ->first();
        $enumsArr = array();
        if ($enums) {
            $enums = rtrim(ltrim($enums->COLUMN_TYPE, "enum('"), "')");
            $enumsArr = explode("','", $enums);
        }
        return $enumsArr;
    }

    /**
     * Common Function to create New User Log in
     * @return User Detail
     */
    public static function createNewUser($data = array(), $organizationId, $role = 'user') {
        $password = '12345678';
        $user_detail = \App\User::create([
                    'OrganizationId' => $organizationId,
                    'firstname' => $data['firstname'],
                    'lastname' => $data['lastname'],
                    'email' => $data['email'],
                    'password' => Hash::make($password)
        ]);
        ################## Assign USer Role #########################
        $user_detail->attachRole(\App\Role::where('name', $role)->first());
        ################## Assign USer Role #########################
        ############### Send User Creation Mail ##########################
        $mailData = array();
        $mailData['toName'] = $data['firstname'] . ' ' . $data['lastname'];
        $mailData['toEmail'] = $data['email'];
        $mailData['subject'] = 'New 360 Hoops User';
        $mailData['tempHtml'] = "emails.users.NewUserMailTemplate";
        $mailData['tempText'] = "emails.users.NewUserMailTemplate";
        $mailData['content'] = "Your 360 Account Login has been created for this Email-Id. Please find Following password to log in:";
        $mailData['password'] = $password;
        $obj = new CommonFunctions();
        $obj->sendEmail($mailData);
        ############### Send User Creation Mail ##########################

        return $user_detail;
    }

    /**
     * Common Function to send Email
     * @return User Detail
     */
    public static function sendEmail($data = array()) {
        $name = 'Hello ' . $data['toName'];
        $templateParams = ['html' => $data['tempHtml'], 'text' => $data['tempText']];
        $sendParams =$data;
        $sendParams['name']=$name;
        $response = \Mail::send($templateParams, $sendParams, function($message) use ($data) {
                    $fromName = Config::get('emails.FROM_EMAIL')['name'];
                    $fromEmail = Config::get('emails.FROM_EMAIL')['email'];
                    $message->from($fromEmail, $fromName);
                    $message->to($data['toEmail'], $data['toName']);
                    $message->subject($data['subject']);
                });
    }

}
