<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\{Auth,Hash, Validator};
use App\Role;

class AuthController extends Controller {

    public $successStatus = 200;

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'unique:users|required|email',
                    'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        } else {
            $input = $request->all(); 
            $data=array();
            $data['name']=$request->filled('name')?$input['name']:NULL;
            $data['email']= $request->filled('email')?$input['email']:NULL;
            $data['password']= $request->filled('password')?Hash::make(trim($input['password'])):NULL;
            $data['registration_id']= $request->filled('reg_id')?$input['reg_id']:NULL;
//             if ($request->hasFile('image')) {
//                 $image = $request->file('image');
//                 $imageName = str_replace('.' . $image->getClientOriginalExtension(), '', $image->getClientOriginalName());
//                 $name = $imageName . '-' . time() . '.' . $image->getClientOriginalExtension();
//                 $destinationPath = 'storage/uploads/users';
//                 $image->move($destinationPath, $name);
//                 $input['image'] = $destinationPath . '/' . $name;
//             }
            $user=User::create($data);   
            
            //Assign USer Role
            $userRole=Role::where('name','user')->first();
            if(!empty($userRole)){
                $user->attachRole($userRole);
            }           
            
            //$user->image = url("/") . "storage/uploads/users/" . $user->image;
            return response()->json(['status'=>'Success','data'=>$user->toArray()]);
        }
    }

    public function login(Request $request) {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $user->generateToken();
            return response()->json([
                        'data' => $user->toArray(),
            ]);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function logout(Request $request) {
        $user = Auth::guard('api')->user();
        if ($user) {
            $user->api_token = null;
            $user->save();
            return response()->json(['data' => 'User logged out.'], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function getUser() {
        $user = Auth::guard('api')->user();
        return response()->json(['success' => $user], $this->successStatus);
    }

}
