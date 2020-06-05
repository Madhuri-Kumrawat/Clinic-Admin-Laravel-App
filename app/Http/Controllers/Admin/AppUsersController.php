<?php
namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\ {
    Config
};
use App\Http\Controllers\Controller as Controller;
use App\User;

class AppUsersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the city Listing.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.app_users');
    }

    /**
     * Function To Fetch All App Users
     *
     * @return mixed Results of Events according to filter parameters
     */
    public function app_users_xhr(Request $request)
    {
        $limit = 10000; // RECORD_LIMIT_10K;
        $skip = 0;
        if ($request->has('start')) {
            $skip = $request->input('start');
        }
        if ($request->has('length')) {
            $limit = $request->input('length');
        }
        $filter = " `users`.`id` != '' ";
        $filter .= " AND `users`.`deleted_at` IS NULL ";
        $order = array(
            '`users`.`created_at`' => "DESC"
        );
        if ($request->has('order')) {
            switch ($request->input('order')[0]['column']) {
                case '1':
                    $order = ($request->input('order')[0]['dir'] == 'desc') ? array(
                        'users.name' => "DESC"
                    ) : array(
                        'users.name' => "ASC"
                    );
                    break;
                case '2':
                    $order = ($request->input('order')[0]['dir'] == 'desc') ? array(
                        'users.email' => "DESC"
                    ) : array(
                        'users.email' => "ASC"
                    );
                    break;
                case '3':
                    $order = ($request->input('order')[0]['dir'] == 'desc') ? array(
                        'users.created_at' => "DESC"
                        ) : array(
                        'users.created_at' => "ASC"
                            );
                        break;
                default:
                    break;
            }
        }
        if (! empty($request->input('search')['value'])) {
            $allWords = str_replace('+', '%', $request->input('search')['value']);
            $v = array();
            $word = trim($allWords);
            if (strlen($word) > 0) {
                $regex = htmlspecialchars($word, ENT_QUOTES);
                $v[] = " `users`.`name` LIKE '%" . $regex . "%' ";
            }
            $keywordfilter = $v;
            $filter .= " and ( " . implode(" OR ", $keywordfilter) . " ) ";
        }
        $app_users = User::app_users_xhr($filter, $limit, $skip, $order);

        $return = new \stdClass();
        $return->draw = $request->input('draw');
        $return->recordsTotal = User::app_users_xhr_count($filter);
        $return->recordsFiltered = $return->recordsTotal;
        $return->data = array();
        if ($app_users) {
            foreach ($app_users as $user) {
                $img_url = '';
                if (! empty($user->profile_image)) {
                    $img_url = '<img class="img-thumbnail " src="' . url($user->profile_image) . '" width="80px" height="80px"  >';
                }
                $action = '<a class="btn btn-info remove_app_user" href="#" data-id="' . $user->id . '" ><i class="fas fa-trash"></i>&nbsp;Delete</a>';
                $return->data[] = array(
                    $img_url,
                    $user->name,
                    $user->email,
                    $user->created_at,
                    $action,
                    'dt' => $user->id
                );
            }
        }
        echo json_encode($return);
    }
    
    
    /**
     * remove the App User
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function removeUser(Request $request) {
        $userId = $request->input('userId');
        if (!empty($userId)) {
            $userDetail = User::where('id', $userId)->whereNull('deleted_at')->first();
            if (!empty($userDetail)) {
                $userDetail->delete();
                echo json_encode(array('success' => true));
                exit;
            } else {
                echo json_encode(array('success' => false, 'msg' => 'No User Found'));
                exit;
            }
        } else {
            echo json_encode(array('success' => false, 'msg' => 'Please provide User'));
            exit;
        }
    }
}
