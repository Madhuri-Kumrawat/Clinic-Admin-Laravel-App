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
use \App\Libraries\CommonFunctions;

use App\Models\ {
    Profile, City
};

use App\Models\Specialist;

class ProfileController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the city Listing.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $specialistTypes = CommonFunctions::getColumnEnumValues("clinic_specialist", "specialist_type");
        return view('admin.profile', compact('specialistTypes'));
    }

    /**
     * Function To Fetch All Cities
     *
     * @return mixed Results of Events according to filter parameters
     */
    public function profile_xhr(Request $request) {
        $limit = 10000; // RECORD_LIMIT_10K;
        $skip = 0;
        if ($request->has('start')) {
            $skip = $request->input('start');
        }
        if ($request->has('length')) {
            $limit = $request->input('length');
        }
        $filter = " `clinic_profile`.`id` != '' ";
        $filter .= " AND `clinic_profile`.`deleted_at` IS NULL ";
        $order = array(
            '`clinic_profile`.`created_at`' => "DESC"
        );
        if ($request->has('order')) {
            switch ($request->input('order')[0]['column']) {
                case '1':
                    $order = ($request->input('order')[0]['dir'] == 'desc') ? array(
                        'clinic_profile.name' => "DESC"
                            ) : array(
                        'clinic_profile.name' => "ASC"
                    );
                    break;
                case '2':
                    $order = ($request->input('order')[0]['dir'] == 'desc') ? array(
                        'clinic_specialist.name' => "DESC"
                            ) : array(
                        'clinic_specialist.name' => "ASC"
                    );
                    break;
                case '3':
                    $order = ($request->input('order')[0]['dir'] == 'desc') ? array(
                        'clinic_specialist.email' => "DESC"
                            ) : array(
                        'clinic_specialist.email' => "ASC"
                    );
                    break;
                case '4':
                    $order = ($request->input('order')[0]['dir'] == 'desc') ? array(
                        'clinic_profile.hours' => "DESC"
                            ) : array(
                        'clinic_profile.hours' => "ASC"
                    );
                    break;
                case '5':
                    $order = ($request->input('order')[0]['dir'] == 'desc') ? array(
                        'clinic_profile.created_at' => "DESC"
                            ) : array(
                        'clinic_profile.created_at' => "ASC"
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
                $v[] = " `clinic_profile`.`name` LIKE '%" . $regex . "%' ";
                $v[] = " `clinic_profile`.`specialist_type` LIKE '%" . $regex . "%' ";
                $v[] = " `clinic_specialist`.`name` LIKE '%" . $regex . "%' ";
                $v[] = " `clinic_profile`.`email` LIKE '%" . $regex . "%' ";
                $v[] = " `clinic_profile`.`city` LIKE '%" . $regex . "%' ";
                $v[] = " `clinic_profile`.`address` LIKE '%" . $regex . "%' ";
            }
            $keywordfilter = $v;
            $filter .= " and ( " . implode(" OR ", $keywordfilter) . " ) ";
        }
        if ($request->filled('specialistType')) {
            $filter .= " AND `clinic_profile`.`specialist_type` = '" . $request->input('specialistType') . "' ";
        }
        $profiles = Profile::profile_xhr($filter, $limit, $skip, $order);

        $return = new \stdClass();
        $return->draw = $request->input('draw');
        $return->recordsTotal = Profile::profile_xhr_count($filter);
        $return->recordsFiltered = $return->recordsTotal;
        $return->data = array();
        if ($profiles) {
            foreach ($profiles as $profile) {
                $img_url = '';
                if (!empty($profile->icon)) {
                    $img_url = '<img class="img-thumbnail " src="' . url($profile->icon) . '" width="80px" height="80px"  >';
                }
                $specialist = $profile->specialist_name;
                $specialist .='<br /><span class="badge badge-info">' . $profile->specialist_type . '</span>';

                $contact = $profile->email;
                $contact .=($profile->phone)?'<br /><span class="badge badge-info"><i class="fas fa-mobile-alt"></i>&nbsp;&nbsp;' . $profile->phone . '</span>':'';

                $action = '<div class="btn-group mb-2">
                                <button type="button" class="btn btn-info">Action</button>
                                <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item edit_profile" href="' . url("admin/profile_detail?id=" . $profile->id) . '"><i class="fas fa-edit"></i>&nbsp;Edit</a>
                                    <a class="dropdown-item remove_profile" href="#" data-id="' . $profile->id . '" ><i class="fas fa-trash"></i>&nbsp;Delete</a>
                                </div>
                            </div>';
                $return->data[] = array(
                    $img_url,
                    $profile->name,
                    $specialist,
                    $contact,
                    $profile->start_hours.' to '.$profile->end_hours,
                    $profile->created_at,
                    $action,
                    'dt' => $profile->id
                );
            }
        }
        echo json_encode($return);
    }

    /**
     * Save New Profile
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function save_profile(Request $request) {
        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required'],
            'profile_email' => ['required', 'email', 'max:100'],
            'specialist_type' => ['required'],
            'services' => ['required'],
            'city' => ['required']
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->sometimes('imageFile', 'mimes:jpeg,jpg,png,gif,svg|required|max:2048', function ($input) use($request) {
            return empty($request->input('hdnImageFile'));
        });
        $validator->sometimes('end_office_hours', 'required', function ($input) use($request) {
            return !empty($request->input('start_office_hours'));
        });
        $validator->sometimes('start_office_hours', 'required', function ($input) use($request) {
            return !empty($request->input('end_office_hours'));
        });
        /*         * * check sPecialists exists ********** */

        $specialistS_count = Specialist::where('specialist_type', $request->input('specialist_type'))->whereNull('deleted_at')->count();
        $validator->sometimes('specialist_id', 'required', function ($input) use($specialistS_count) {
            return $specialistS_count > 0;
        });

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            if ($request->filled('profileId')) {
                $profileObj = Profile::find($request->input('profileId'));
            } else {
                $profileObj = new Profile();
            }
            $profileObj->name = $request->filled('name') ? $request->input('name') : NULL;
            $profileObj->phone = $request->filled('phone') ? $request->input('phone') : NULL;
            $profileObj->email = $request->filled('profile_email') ? $request->input('profile_email') : NULL;
            $profileObj->cityId = $request->filled('city') ? $request->input('city') : NULL;
            $profileObj->specialist_type = $request->filled('specialist_type') ? $request->input('specialist_type') : NULL;
            $profileObj->specialist_id = $request->filled('specialist_id') ? $request->input('specialist_id') : NULL;
            $profileObj->services = $request->filled('services') ? $request->input('services') : NULL;
            $profileObj->start_hours = $request->filled('start_office_hours') ? $request->input('start_office_hours') : NULL;
            $profileObj->end_hours = $request->filled('end_office_hours') ? $request->input('end_office_hours') : NULL;
            $profileObj->about = $request->filled('about') ? $request->input('about') : NULL;
            $profileObj->address = $request->filled('address') ? $request->input('address') : NULL;
            $profileObj->google_plus = $request->filled('google_plus') ? $request->input('google_plus') : NULL;
            $profileObj->facebook = $request->filled('facebook') ? $request->input('facebook') : NULL;
            $profileObj->twiter = $request->filled('twiter') ? $request->input('twiter') : NULL;
            $profileObj->linkedin = $request->filled('linkedin') ? $request->input('linkedin') : NULL;
            $profileObj->lat = $request->filled('lat') ? $request->input('lat') : NULL;
            $profileObj->lon = $request->filled('lon') ? $request->input('lon') : NULL;

            if ($request->hasFile('imageFile')) {
                $image = $request->file('imageFile');
                $imageName = str_replace('.' . $image->getClientOriginalExtension(), '', $image->getClientOriginalName());
                $name = $imageName . '-' . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = 'storage/uploads/specialists';
                $image->move($destinationPath, $name);
                $profileObj->icon = $destinationPath . '/' . $name;
            }
            $profileObj->save();
            return Redirect::to('admin/profile')->with('msg', 'The Profile has been saved successfully.');
        }
    }

    /**
     * Fetch Detail of  the Profile
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile_detail(Request $request) {
        $profileId = @$request->id;
        $profile = new Profile();
        if (!empty(@$profileId)) {
            $profile = Profile::where("id", @$profileId)->first();
        }
        $specialistTypes = CommonFunctions::getColumnEnumValues("clinic_specialist", "specialist_type");
        $cities = City::select('name', 'id')->whereNull('deleted_at')->get();
        return view('admin.profile_detail', compact('specialistTypes', 'cities', 'profile'));
    }

    /**
     * remove the Profile
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function removeProfile(Request $request) {
        $profile_id = $request->input('profileId');
        if (!empty($profile_id)) {
            $profileDetail = Profile::where('id', $profile_id)->whereNull('deleted_at')->first();
            if (!empty($profileDetail)) {
                $profileDetail->delete();
                echo json_encode(array('success' => true));
                exit;
            } else {
                echo json_encode(array('success' => false, 'msg' => 'No Profile Found'));
                exit;
            }
        } else {
            echo json_encode(array('success' => false, 'msg' => 'Please provide Profile'));
            exit;
        }
    }

}
