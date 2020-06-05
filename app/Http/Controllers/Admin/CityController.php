<?php
namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\ {
    Config
};
use App\Http\Controllers\Controller as Controller;
use App\Models\City;

class CityController extends Controller
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
        return view('admin.city');
    }

    /**
     * Function To Fetch All Cities
     *
     * @return mixed Results of Events according to filter parameters
     */
    public function city_xhr(Request $request)
    {
        $limit = 10000; // RECORD_LIMIT_10K;
        $skip = 0;
        if ($request->has('start')) {
            $skip = $request->input('start');
        }
        if ($request->has('length')) {
            $limit = $request->input('length');
        }
        $filter = " `clinic_city`.`id` != '' ";
        $filter .= " AND `clinic_city`.`deleted_at` IS NULL ";
        $order = array(
            '`clinic_city`.`created_at`' => "DESC"
        );
        if ($request->has('order')) {
            switch ($request->input('order')[0]['column']) {
                case '0':
                    $order = ($request->input('order')[0]['dir'] == 'desc') ? array(
                        'clinic_city.name' => "DESC"
                    ) : array(
                        'clinic_city.name' => "ASC"
                    );
                    break;
                case '1':
                    $order = ($request->input('order')[0]['dir'] == 'desc') ? array(
                        'clinic_city.created_at' => "DESC"
                    ) : array(
                        'clinic_city.created_at' => "ASC"
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
                $v[] = " `clinic_city`.`name` LIKE '%" . $regex . "%' ";
            }
            $keywordfilter = $v;
            $filter .= " and ( " . implode(" OR ", $keywordfilter) . " ) ";
        }
        $cities = City::city_xhr($filter, $limit, $skip, $order);

        $return = new \stdClass();
        $return->draw = $request->input('draw');
        $return->recordsTotal = City::city_xhr_count($filter);
        $return->recordsFiltered = $return->recordsTotal;
        $return->data = array();
        if ($cities) {
            foreach ($cities as $city) {
                $action = '<div class="btn-group mb-2">
                                <button type="button" class="btn btn-info">Action</button>
                                <button type="button" class="btn btn-info dropdown-toggle dropdown-icon"  id="dropdownMenu' . $city->id . '" aria-haspopup="true" data-toggle="dropdown" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                   </button>
                                 <div class="dropdown-menu" role="menu"  aria-labelledby="dropdownMenu' . $city->id . '">
                                        <a class="dropdown-item edit_city" href="#" data-id="' . $city->id . '" ><i class="fas fa-edit"></i>&nbsp;Edit</a>
                                        <a class="dropdown-item remove_city" href="#" data-id="' . $city->id . '" ><i class="fas fa-trash"></i>&nbsp;Delete</a>
                                    </div>
                                
                            </div>';
                $return->data[] = array(
                    $city->name,
                    $city->created_at,
                    $action,
                    'dt' => $city->id
                );
            }
        }
        echo json_encode($return);
    }
    
    /**
     * Fetch Detail of  the City
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function city_detail(Request $request) {
        $cityId = $request->input('cityId');
        $cityDetail = City::where('id', $cityId)->whereNull('deleted_at')->first();
        if (!empty($cityDetail)) {
            echo json_encode(array('success' => true, 'cityInfo' => $cityDetail));
            exit;
        } else {
            echo json_encode(array('success' => false, 'msg' => 'No City Found!'));
            exit;
        }
    }
    
    /**
     * remove the City
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function removeCity(Request $request) {
        $cityId = $request->input('cityId');
        if (!empty($cityId)) {
            $cityDetail = City::where('id', $cityId)->whereNull('deleted_at')->first();
            if (!empty($cityDetail)) {
                $cityDetail->delete();
                echo json_encode(array('success' => true));
                exit;
            } else {
                echo json_encode(array('success' => false, 'msg' => 'No City Found'));
                exit;
            }
        } else {
            echo json_encode(array('success' => false, 'msg' => 'Please provide City'));
            exit;
        }
    }
    /**
     * Save New City
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function saveCity(Request $request)
    {
        $cityId = $request->input('cityId');
        if ($request->filled('cityName')) {
            $existingCity = City::select('clinic_city.*')->where(DB::raw('LOWER(name)'), strtolower(trim($request->input('cityName'))))
                ->whereNull('deleted_at')
                ->first();
            if (! empty($existingCity)) {
                echo json_encode(array(
                    'success' => false,
                    'msg' => 'City alreay Exists!'
                ));
                exit();
            } else {
                if ($cityId) {
                    $cityObj = City::select('clinic_city.*')->where('id', $cityId)
                        ->whereNull('deleted_at')
                        ->first();
                    if (empty($cityObj)) {
                        $cityObj = new City();
                    }
                } else {
                    $cityObj = new City();
                }

                $cityObj->name = trim($request->input('cityName'));
                $cityObj->save();
                echo json_encode(array(
                    'success' => true
                ));
                exit();
            }
        } else {
            echo json_encode(array(
                'success' => false,
                'msg' => 'Please Enter Valid City'
            ));
            exit();
        }
    }
}
