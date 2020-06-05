<?php
namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\ {
    Config,
    Validator
};
use App\Http\Controllers\Controller as Controller;
use App\Libraries\CommonFunctions;
use App\Models\Specialist;

class SpecialistsController extends Controller
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
        $specialistTypes = CommonFunctions::getColumnEnumValues("clinic_specialist", "specialist_type");
        return view('admin.specialists', compact('specialistTypes'));
    }

    /**
     * Function To Fetch All Cities
     *
     * @return mixed Results of Events according to filter parameters
     */
    public function specialists_xhr(Request $request)
    {
        $limit = 10000; // RECORD_LIMIT_10K;
        $skip = 0;
        if ($request->has('start')) {
            $skip = $request->input('start');
        }
        if ($request->has('length')) {
            $limit = $request->input('length');
        }
        $filter = " `clinic_specialist`.`id` != '' ";
        $filter .= " AND `clinic_specialist`.`deleted_at` IS NULL ";
        $order = array(
            '`clinic_specialist`.`created_at`' => "DESC"
        );
        if ($request->has('order')) {
            switch ($request->input('order')[0]['column']) {
                case '1':
                    $order = ($request->input('order')[0]['dir'] == 'desc') ? array(
                        'clinic_specialist.name' => "DESC"
                    ) : array(
                        'clinic_specialist.name' => "ASC"
                    );
                    break;
                case '2':
                    $order = ($request->input('order')[0]['dir'] == 'desc') ? array(
                        'clinic_specialist.specialist_type' => "DESC"
                    ) : array(
                        'clinic_specialist.specialist_type' => "ASC"
                    );
                    break;
                case '3':
                    $order = ($request->input('order')[0]['dir'] == 'desc') ? array(
                        'clinic_specialist.created_at' => "DESC"
                    ) : array(
                        'clinic_specialist.created_at' => "ASC"
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
                $v[] = " `clinic_specialist`.`name` LIKE '%" . $regex . "%' ";
                $v[] = " `clinic_specialist`.`specialist_type` LIKE '%" . $regex . "%' ";
            }
            $keywordfilter = $v;
            $filter .= " and ( " . implode(" OR ", $keywordfilter) . " ) ";
        }
        if ($request->filled('specialistType')) {
            $filter .= " AND `clinic_specialist`.`specialist_type` = '" . $request->input('specialistType') . "' ";
        }
        $specialists = Specialist::specialists_xhr($filter, $limit, $skip, $order);

        $return = new \stdClass();
        $return->draw = $request->input('draw');
        $return->recordsTotal = Specialist::specialists_xhr_count($filter);
        $return->recordsFiltered = $return->recordsTotal;
        $return->data = array();
        if ($specialists) {
            foreach ($specialists as $specialist) {
                $img_url = '';
                if (! empty($specialist->icon)) {
                    $img_url = '<img class="img-thumbnail " src="' . url($specialist->icon) . '" width="80px" height="80px"  >';
                }
                $action = '<div class="btn-group mb-2">
                                <button type="button" class="btn btn-info">Action</button>
                                <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item edit_specialist" href="#" data-id="' . $specialist->id . '" ><i class="fas fa-edit"></i>&nbsp;Edit</a>
                                    <a class="dropdown-item remove_specialist" href="#" data-id="' . $specialist->id . '" ><i class="fas fa-trash"></i>&nbsp;Delete</a>
                                </div>
                            </div>';
                $return->data[] = array(
                    $img_url,
                    $specialist->name,
                    $specialist->specialist_type,
                    $specialist->created_at,
                    $action,
                    'dt' => $specialist->id
                );
            }
        }
        echo json_encode($return);
    }

    /**
     * Save New City
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function saveSpecialist(Request $request)
    {
        $fileImage = '';
        $rules = array(
            'imageFile' => 'mimes:jpeg,jpg,png,gif,svg|required|max:2048'
        );
        $specialist_id = $request->input('specialistId');
        if ($request->filled('specialistName') && $request->filled('specialist_type')) {

            if (! empty($specialist_id)) {
                $specialistObj = Specialist::where('id', $specialist_id)->whereNull('deleted_at')->first();
                if (empty($specialistObj)) {
                    $specialistObj = new Specialist();
                }
            } else {
                $specialistObj = new Specialist();
            }

            if(empty($request->filled('specialistImage'))){

                // validator Rules
                $validator = Validator::make($request->only('imageFile'), $rules);

                // Check validation (fail or pass)
                if ($validator->fails()) {
                    echo json_encode(array(
                        'success' => false,
                        'msg' => $validator->errors()->first()
                    ));
                    exit();
                } else {
                    if ($request->hasFile('imageFile')) {
                        $image = $request->file('imageFile');
                        $imageName = str_replace('.' . $image->getClientOriginalExtension(), '', $image->getClientOriginalName());
                        $name = $imageName . '-' . time() . '.' . $image->getClientOriginalExtension();
                        $destinationPath = 'storage/uploads/specialists';
                        $image->move($destinationPath, $name);
                        $fileImage = $specialistObj->icon = $destinationPath . '/' . $name;
                    }
                }
            }
            if (! empty($specialist_id) && empty($fileImage) && empty($request->filled('specialistImage'))) {
                echo json_encode(array(
                    'success' => false,
                    'msg' => "Please Upload Image"
                ));
                exit();
            }

            $specialistObj->name = trim($request->input('specialistName'));
            $specialistObj->specialist_type = trim($request->input('specialist_type'));
            $specialistObj->save();
            echo json_encode(array(
                'success' => true
            ));
            exit();
        } else {
            echo json_encode(array(
                'success' => false,
                'msg' => 'Please Enter Required Values'
            ));
            exit();
        }
    }

    /**
     * Fetch Detail of the Specialist
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function specialist_detail(Request $request)
    {
        $specialistId = $request->input('specialistId');
        $specialistDetail = Specialist::where('id', $specialistId)->whereNull('deleted_at')->first();
        if (! empty($specialistDetail)) {
            echo json_encode(array(
                'success' => true,
                'specialistInfo' => $specialistDetail
            ));
            exit();
        } else {
            echo json_encode(array(
                'success' => false,
                'msg' => 'No Specialist Found!'
            ));
            exit();
        }
    }

    /**
     * remove the Specialist
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function removeSpecialist(Request $request)
    {
        $specialist_id = $request->input('specialistId');
        if (! empty($specialist_id)) {
            $specialistDetail = Specialist::where('id', $specialist_id)->whereNull('deleted_at')->first();
            if (! empty($specialistDetail)) {
                $specialistDetail->delete();
                echo json_encode(array(
                    'success' => true
                ));
                exit();
            } else {
                echo json_encode(array(
                    'success' => false,
                    'msg' => 'No Specialist Found'
                ));
                exit();
            }
        } else {
            echo json_encode(array(
                'success' => false,
                'msg' => 'Please provide Specialist'
            ));
            exit();
        }
    }

    /**
     * get the Specialist by Condition
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function get_specialist(Request $request)
    {
        $specialist_type = $request->input("specialist_type");
        $specialistData = array();
        if ($specialist_type) {
            $specialistData = Specialist::where('specialist_type', $specialist_type)->whereNull('deleted_at')->get();
        }
        return json_encode(array("specialists" =>$specialistData));
    }
}
