<?php

namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\ {
    Redirect,
    Config,
    Validator
};

use App\Http\Controllers\Controller as Controller;
use App\Models\Notification;
use App\Models\SendNotification;
use App\Models\Tokendata;

class NotificationController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the Notifications.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view('admin.notification');
    }

    /**
     * Function To Fetch All Notifications
     *
     * @return mixed Results of Events according to filter parameters
     */
    public function notification_xhr(Request $request) {
        $limit = 10000; // RECORD_LIMIT_10K;
        $skip = 0;
        if ($request->has('start')) {
            $skip = $request->input('start');
        }
        if ($request->has('length')) {
            $limit = $request->input('length');
        }
        $filter = " `clinic_sendnotification`.`id` != '' ";
        $filter .= " AND `clinic_sendnotification`.`deleted_at` IS NULL ";
        $order = array(
            '`clinic_sendnotification`.`created_at`' => "DESC"
        );
        if ($request->has('order')) {
            switch ($request->input('order')[0]['column']) {
                case '1':
                    $order = ($request->input('order')[0]['dir'] == 'desc') ? array(
                        'clinic_sendnotification.message' => "DESC"
                            ) : array(
                        'clinic_sendnotification.message' => "ASC"
                    );
                    break;
                default:
                    break;
            }
        }
        if (!empty($request->input('search')['value'])) {
            $allWords = str_replace('+', '%', $request->input('search')['value']);
            $v = array();
            $word = trim($allWords);
            if (strlen($word) > 0) {
                $regex = htmlspecialchars($word, ENT_QUOTES);
                $v[] = " `clinic_sendnotification`.`message` LIKE '%" . $regex . "%' ";
            }
            $keywordfilter = $v;
            $filter .= " and ( " . implode(" OR ", $keywordfilter) . " ) ";
        }

        $sendnotifications = SendNotification::notification_xhr($filter, $limit, $skip, $order);

        $return = new \stdClass();
        $return->draw = $request->input('draw');
        $return->recordsTotal = SendNotification::notification_xhr_count($filter);
        $return->recordsFiltered = $return->recordsTotal;
        $return->data = array();
        if ($sendnotifications) {
            foreach ($sendnotifications as $sendnotification) {
                $return->data[] = array(
                    $sendnotification->id,
                    $sendnotification->message,
                    $sendnotification->created_at,
                    'dt' => $sendnotification->id
                );
            }
        }
        echo json_encode($return);
    }

    /**
     * Function To Send Notification Message
     *
     * @return
     */
    public function send_notification_message(Request $request) {
        $rules = [
            'message' => ['required']
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            $message = $request->filled('message') ? $request->input('message') : NULL;
            $google_api_key = GOOGLE_API_KEY;

            $objTokendata = Tokendata::get()->pluck("device_id")->toArray();
            if (count($objTokendata) > 0) {
                $registrationIds = $objTokendata;
                $message = array('message' => $message);
                $fields = array(
                    'registration_ids' => $registrationIds,
                    'data' => $message
                );
                $url = 'https://fcm.googleapis.com/fcm/send';
                $headers = array(
                    'Authorization: key=' . $google_api_key, // . $api_key,
                    'Content-Type: application/json'
                );
                $json = json_encode($fields);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                $result = curl_exec($ch);
                if ($result === FALSE) {
                    echo json_encode(array('success' => false, 'msg' => 'Curl failed: ' . curl_error($ch)));
                }
                curl_close($ch);
                $response = json_decode($result, true);

                if ($response['success']) {
                    $objSendNotification = new SendNotification();
                    $objSendNotification->message = $massage;
                    $resSendNotification = $objSendNotification->save();
                    echo json_encode(array('success' => true));
                    exit;
                } else {
                    echo json_encode(array('success' => false, 'msg' => 'Something went wrong!'));
                    exit;
                }
            } else {
                echo json_encode(array('success' => false, 'msg' => 'No Device Found'));
                exit;
            }
        }
    }

    /**
     * Show the Notification Settings.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function notification_setting() {
        $notification = Notification::first();
        return view('admin.notification_setting', compact('notification'));
    }

    /**
     * Save Notification Settings.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function save_notification_setting(Request $request) {
        $rules = [
            'apikey' => ['required'],
            'passphrace' => ['required'],
            'file' => ['mimes:pem|required'],
            'environment' => ['required']
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            $notification = Notification::first();
            $notification->apikey = $request->filled('apikey') ? $request->input('apikey') : NULL;
            $notification->passphrace = $request->filled('passphrace') ? $request->input('passphrace') : NULL;
            $notification->environment = $request->filled('environment') ? $request->input('environment') : NULL;
            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $imageName = str_replace('.' . $image->getClientOriginalExtension(), '', $image->getClientOriginalName());
                $name = $imageName . '-' . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = 'storage/uploads/certificate';
                $image->move($destinationPath, $name);
                $profileObj->icon = $destinationPath . '/' . $name;
            }
            $notification->save();
            return Redirect::to('admin/notification_setting')->with('msg', 'The notification setting has been saved successfully.');
        }
    }

}
