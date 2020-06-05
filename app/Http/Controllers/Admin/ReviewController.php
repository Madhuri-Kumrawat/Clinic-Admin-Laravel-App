<?php
namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\ {
    Config
};
use App\Http\Controllers\Controller as Controller;
use App\Models\Review;

class ReviewController extends Controller
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
     * Show the REviews Listing.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.reviews');
    }

    /**
     * Function To Fetch All REview
     *
     * @return mixed Results of Reviews according to filter parameters
     */
    public function reviews_xhr(Request $request)
    {
        $limit = 10000; // RECORD_LIMIT_10K;
        $skip = 0;
        if ($request->has('start')) {
            $skip = $request->input('start');
        }
        if ($request->has('length')) {
            $limit = $request->input('length');
        }
        $filter = " `clinic_review`.`id` != '' ";
        $filter .= " AND `clinic_review`.`deleted_at` IS NULL ";
        $order = array(
            '`clinic_review`.`created_at`' => "DESC"
        );
        if ($request->has('order')) {
            switch ($request->input('order')[0]['column']) {
                case '0':
                    $order = ($request->input('order')[0]['dir'] == 'desc') ? array(
                        'clinic_profile.name' => "DESC"
                    ) : array(
                        'clinic_profile.name' => "ASC"
                    );
                    break;
                case '1':
                    $order = ($request->input('order')[0]['dir'] == 'desc') ? array(
                        'clinic_review.review_text' => "DESC"
                    ) : array(
                        'clinic_review.review_text' => "ASC"
                    );
                    break;
                case '2':
                    $order = ($request->input('order')[0]['dir'] == 'desc') ? array(
                        'clinic_review.ratting' => "DESC"
                        ) : array(
                        'clinic_review.ratting' => "ASC"
                            );
                        break;
                case '3':
                    $order = ($request->input('order')[0]['dir'] == 'desc') ? array(
                         'users.name' => "DESC"
                        ) : array(
                        'users.name' => "ASC"
                            );
                        break;
                case '4':
                    $order = ($request->input('order')[0]['dir'] == 'desc') ? array(
                    'clinic_review.created_at' => "DESC"
                        ) : array(
                        'clinic_review.created_at' => "ASC"
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
                $v[] = " `clinic_review`.`review_text` LIKE '%" . $regex . "%' ";
                $v[] = " `clinic_review`.`ratting` LIKE '%" . $regex . "%' ";
                $v[] = " `clinic_profile`.`name` LIKE '%" . $regex . "%' ";
            }
            $keywordfilter = $v;
            $filter .= " and ( " . implode(" OR ", $keywordfilter) . " ) ";
        }
        $reviews = Review::review_xhr($filter, $limit, $skip, $order);

        $return = new \stdClass();
        $return->draw = $request->input('draw');
        $return->recordsTotal = Review::review_xhr_count($filter);
        $return->recordsFiltered = $return->recordsTotal;
        $return->data = array();
        if ($reviews) {
            foreach ($reviews as $r) {
                $profile=$r->profile_name.'<br/><span class="badge badge-info">'.$r->specialist_type.'</span>';
                $action = '<a class="btn btn-info remove_review" href="#" data-id="' . $r->id . '" ><i class="fas fa-trash"></i>&nbsp;Delete</a>';
                $return->data[] = array(
                    $profile,
                    $r->review_text,
                    $r->ratting,
                    $r->user_name,
                    $r->created_at,
                    $action,
                    'dt' => $r->id
                );
            }
        }
        echo json_encode($return);
    }
    
    
    /**
     * remove the Review
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function removeReview(Request $request) {
        $reviewId = $request->input('reviewId');
        if (!empty($reviewId)) {
            $reviewDetail = Review::where('id', $reviewId)->whereNull('deleted_at')->first();
            if (!empty($reviewDetail)) {
                $reviewDetail->delete();
                echo json_encode(array('success' => true));
                exit;
            } else {
                echo json_encode(array('success' => false, 'msg' => 'No Review Found'));
                exit;
            }
        } else {
            echo json_encode(array('success' => false, 'msg' => 'Please Select Review'));
            exit;
        }
    }
}
