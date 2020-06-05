<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\{Review,Specialist,City , Appointment,BookmarkProfile};
use App\User;

class IndexController extends Controller
{

    /**
     * Get All City
     */
    public function getCity(Request $request)
    {
        $objCity = City::all();
        if (! empty($objCity) && count($objCity) > 0) {
            return response()->json([
                "status" => "Success",
                'data' => $objCity->toArray()
            ], 200);
        } else {
            return response()->json([
                'error' => 'City Not Found'
            ], 401);
        }
    }

    /**
     * Get All Specialities
     */
    public function getSpecialities(Request $request)
    {
        $objSpecialist = Specialist::query();
        if ($request->has("specialist_type")) {
            $objSpecialist->where("specialist_type", $request->input("specialist_type"));
        }
        $objSpecialist = $objSpecialist->get();
        if (! empty($objSpecialist) && count($objSpecialist) > 0) {
            return response()->json([
                "status" => "Success",
                'data' => $objSpecialist->toArray()
            ], 200);
        } else {
            return response()->json([
                'error' => 'Specialities Not Found'
            ], 401);
        }
    }

    /**
     * Get Profile List
     */
    public function getProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'specialist_type' => 'required',
            'lat' => 'required',
            'lon' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 401);
        } else {
            $lat = @$request->lat;
            $lon = @$request->lon;
            $specialist_type = @$request->specialist_type;
            $extracnd = "";
            if ($request->has("city_id")) {
                $extracnd = " AND `cityId` = '$request->city_id'";
            }
            $objProfile = DB::select("SELECT *,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( `lat` ) ) *
                COS( RADIANS( `lon` ) - RADIANS( $lon ) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( `lat` ) ) ) ) AS distance
                from clinic_profile where specialist_type = '$specialist_type' $extracnd ORDER BY distance ASC ");
           if (! empty($objProfile) && count($objProfile) > 0) {
                return response()->json([
                    "status" => "Success",
                    'data' => $objProfile
                ], 200);
            } else {
                return response()->json([
                    'error' => 'Profile Not Found'
                ], 401);
            }
        }
    }

    /**
     * Get Review
     */
    public function getProfileDetail(Request $request)
    {       
        $validator = Validator::make($request->all(), [
            'profile_id' => 'required',
            'lat' => 'required',
            'lon' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 401);
        } else {
            $data=array();
            $lat = @$request->lat;
            $lon = @$request->lon;
            $profile_id = @$request->profile_id;
            $objProfiles = DB::select("SELECT clinic_profile.*,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( `lat` ) ) *
                COS( RADIANS( `lon` ) - RADIANS( $lon ) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( `lat` ) ) ) ) AS distance,
                COALESCE(AVG(ratting),0) AS ratavg
                from clinic_profile 
                LEFT JOIN clinic_review ON `clinic_profile`.`id`=`clinic_review`.`profile_id` AND `clinic_review`.`deleted_at` IS NULL
                WHERE `clinic_profile`.`id` = $profile_id
                AND `clinic_profile`.`deleted_at` IS NULL
                GROUP BY `clinic_profile`.`id`
                ORDER BY distance ASC");
            // HAVING distance < 20 
            if (! empty($objProfiles) && count($objProfiles) > 0) {
                $objProfile = @$objProfiles[0];
                $radiusdata = $objProfile->distance * 1.609344;
                $km = round($radiusdata, 2);
                $ratting =$objProfile->ratavg;
                $data[] = array(
                    "id" => $objProfile->id,
                    "ratting" => $ratting,
                    "icon" => $objProfile->icon,
                    "name" => $objProfile->name,
                    "phone" => $objProfile->phone,
                    "email" => $objProfile->email,
                    "start_hours" => $objProfile->start_hours,
                    "end_hours" => $objProfile->end_hours,
                    "lat" => $objProfile->lat,
                    "lon" => $objProfile->lon,
                    "about" => $objProfile->about,
                    "services" => $objProfile->services,
                    "address" => $objProfile->address,
                    "goole_plus" => $objProfile->google_plus,
                    "helthcare" => $objProfile->helthcare,
                    "facebook" => $objProfile->facebook,
                    "twiter" => $objProfile->twiter,
                    "distance" => $objProfile->distance,
                    "distancekm" => $km
                );
                return response()->json([
                    "status" => "Success",
                    'data' => $data
                ], 200);
            } else {
                return response()->json([
                    'error' => 'Profile Not Found'
                ], 401);
            }
        }
    }
    
    /**
     * Get Review Detail
     */
    public function getReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_id' => 'required'
        ]);
        $data = array();
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 401);
        } else {
            $profile_id = @$request->profile_id;
            $objProfiles = Review::select("clinic_review.id", "email", "name", "image", "review_text", "ratting", "clinic_review.created_at")->join("users", "users.id", "=", "clinic_review.user_id")
                ->where("profile_id", $profile_id)
                ->get();
            if (! empty($objProfiles) && count($objProfiles) > 0) {
                foreach ($objProfiles as $objProfile) {
                    $image = $objProfile->image;
                    if ($objProfile->reg_type == "appuser" && ! empty($objProfile->image)) {
                        $image = url("/") . "storage/uploads/" . $objProfile->image;
                    }
                    $data[] = array(
                        "id" => $objProfile->id,
                        "username" => $objProfile->name,
                        "useremail" => $objProfile->email,
                        "userimage" => $image,
                        "review_text" => $objProfile->review_text,
                        "ratting" => $objProfile->ratting,
                        "created_at" => $objProfile->created_at
                    );
                }
                return response()->json([
                    "status" => "Success",
                    'data' => $data
                ], 200);
            } else {
                return response()->json([
                    'error' => 'Review Not Found'
                ], 401);
            }
        }
    }

    /**
     * Post Review
     */
    public function postReviewRating(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_id' => 'required',
            'user_id' => 'required',
            'ratting'=>'required_without:review_text',
            'review_text'=>'required_without:ratting',
            
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 401);
        } else {
            $profile_id = @$request->profile_id;
            $user_id = @$request->user_id;
            $review_text = @$request->review_text;
            $ratting = @$request->ratting;
            $objReviewRatting = new \App\Models\Review();
            $objReviewRatting->user_id = $user_id;
            $objReviewRatting->profile_id = $profile_id;
            $objReviewRatting->review_text = $review_text;
            $objReviewRatting->ratting = $ratting;
            $objReviewRatting->save();
            return response()->json([
                "status" => "Success"
            ], 200);
        }
    }

    /**
     * Get Rating
     */
    public function getratting(Request $request)
    {
        $data=array();
        $validator = Validator::make($request->all(), [
            'profile_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 401);
        } else {
            $profile_id=@$request->profile_id;
            $objRatings = Review::select(DB::raw("AVG(ratting) AS ratavg"))->where('profile_id', $profile_id)->groupBy('profile_id')
                ->whereNull('deleted_at')
                ->first();
            if (!empty($objRatings)) {
                $avg = round($objRatings->ratavg, 1);
                $data['ratting']=$avg;
                return response()->json([
                    "status" => "Success",'data'=>$data
                ], 200);
            } else {
                return response()->json([
                    "status" => "Success",'data'=>0
                ], 200);
            }
        }
    }
    
    /**
     * Book an Apoitmnet with a Doctor
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bookAppointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_id' => 'required',
            'user_id' => 'required',
            'appointment_date'=>'required',
            'description'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 401);
        } else {
            $insert_data=array();
            $insert_data['profile_id']=@$request->profile_id;
            $insert_data['user_id']  = @$request->user_id;
            $insert_data['appointment_date']=date('Y-m-d',strtotime(@$request->appointment_date));
            $insert_data['appointment_time']=@$request->appointment_time;
            $insert_data['description']=@$request->description;
            
            Appointment::insert($insert_data);
            return response()->json([
                "status" => "Success"], 200);
        }
    }
    
    /**
     * Book an Apoitmnet with a Doctor
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bookmarkProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_id' => 'required',
            'user_id' => 'required',
            'bookmarkStatus'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 401);
        } else {
            $user_id=@$request->user_id;
            $profile_id=@$request->profile_id;
            $bookmarkStatus=@$request->bookmarkStatus;
            
            $bookmark_profile_detail = BookmarkProfile::where('user_id',$user_id)->where("profile_id",$profile_id)->first();
            if(!empty($bookmark_profile_detail)){
                $bookmark_profile_detail->bookmarkStatus=$bookmarkStatus;
                $bookmark_profile_detail->save();
            }else{
                $bookmark_profile_array=array();
                $bookmark_profile_array->user_id=$user_id;
                $bookmark_profile_array->profile_id=$profile_id;
                $bookmark_profile_array->bookmarkStatus=$bookmarkStatus;
                BookmarkProfile::insert($bookmark_profile_array);
            }
            return response()->json([
                "status" => "Success"], 200);
        }
    }
    
    /**
     * Upload Profile Picture
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadProfilePicture(Request $request)
    {
        $rules = [
            'imageFile' => ['required', 'mimes:jpeg,jpg,png,gif,svg|required|max:2048'],
            'user_id'=>'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 401);
        } else {
            $user_detail=User::where('id',$request->user_id)->whereNull('deleted_at')->first();
            
            if(empty($user_detail)){
                return response()->json([
                    'error' => 'User Not Found'
                ], 401);
            }else{
                if ($request->hasFile('imageFile')) {
                    $image = $request->file('imageFile');
                    $imageName = str_replace('.' . $image->getClientOriginalExtension(), '', $image->getClientOriginalName());
                    $name = $imageName . '-' . time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = 'storage/uploads/users';
                    $image->move($destinationPath, $name);
                    $user_detail->image = $destinationPath . '/' . $name;
                    
                    return response()->json([
                        "status" => "Success"], 200);
                }else{
                    return response()->json([
                        'error' => 'Image file Not Found'
                    ], 401);
                }
            }
        }
    }
}
