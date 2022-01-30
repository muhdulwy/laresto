<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends BaseController
{    
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'username' => 'required',
    //         'password' => 'required',
    //         'c_password' => 'required|same:password',
    //     ]);
   
    //     if($validator->fails()){
    //         return $this->sendError('Validation Error.', $validator->errors());       
    //     }
   
    //     $input = $request->all();
    //     $input['password'] = bcrypt($input['password']);
    //     $user = User::create($input);
    //     $success['token'] =  $user->createToken('MyApp')->plainTextToken;
    //     $success['name'] =  $user->name;
   
    //     return $this->sendResponse($success, 'User register successfully.');
    // }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    // public function login(Request $request)
    // {
    //     if(Auth::attempt(['username' => $request->username, 'password' => $request->password])){ 
    //         $user = Auth::user(); 
    //         $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
    //         $success['name'] =  $user->name;
   
    //         return $this->sendResponse($success, 'User login successfully.');
    //     } 
    //     else{ 
    //         return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
    //     } 
    // }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('username', 'password')))
        {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('username', $request['username'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        
        return response()
            ->json(['message' => 'Hi '.$user->name.', welcome to home','access_token' => $token, 'token_type' => 'Bearer', ]);
    } 
    public function logout (Request $request) {
        auth()->user()->tokens()->delete();

        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }    
}
