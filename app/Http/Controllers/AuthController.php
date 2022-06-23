<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Mail\VerifyEmail;
use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\PasswordReset;

class AuthController extends Controller
{
    private $user;
    private $password_reset;
    public function __construct(User $user, PasswordReset $password_reset)
    {
        $this->user = $user;
        $this->password_reset = $password_reset;
    }
//this function to check authentication
    public function checkAuth()
    {
        try {
            if (Auth::check()) {
                return (new ResponseHelper(true, "Auth Alive success", 200))->get();
            }
            return (new ResponseHelper(false, "Auth Alive Failed", 401))->get();
        }catch (\Exception $ex){
            Log::info("AuthController",["checkAuth"=>$ex->getMessage(),"line"=>$ex->getLine()]);
            return response()->json(["status"=>false,"message"=>"Auth Alive Failed"])->setStatusCode(500);
        }
    }
// this function sign up
    public function registerAuth(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:8'
            ], [
                'name.required' => 'name Field is Required',
                'email.email' => 'Valid Email Address'
            ]);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return (new ResponseHelper(false, $error, 400))->get();
            }
            $result = $this->user->checkUserExist($request->email);
            if ($result) {
                return (new ResponseHelper(false, "User Already Exist", 400))->get();
            }
            $password = Hash::make($request->password);
            $result = $this->user->registerAuth($request->name, $request->email, $password);
            if ($result) {
                return (new ResponseHelper(true, 'user register success', 200))->get();
            }
            return (new ResponseHelper(false, 'error while register user', 400))->get();
        } catch (\Exception $ex) {
            Log::info('UserControllerError', ['message' => $ex->getMessage(), 'line' => $ex->getLine()]);
            return (new ResponseHelper(false, 'internal server Error', 500))->get();
        }

    }
// this function login
    public function loginAuth(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return (new ResponseHelper(false, $error, 400))->get();
            }
            $result = $this->user->loginAuth($request->email);
            if (isset($result) && !empty($result)) {
                if (Hash::check($request->password, $result->password)) {
                    Auth::login($result);
                    return (new ResponseHelper(true, "Authentication Success", 200))->get();
                }
            }
            return (new ResponseHelper(false, "Invalid Credential", 400))->get();
        } catch (\Exception $ex) {
            return (new ResponseHelper(false, 'internal server Error', 500))->get();
        }
    }



// this function logout
    public function logout()
    {
        try {
            if (Auth::check()) {
                Auth::logout();
                return (new ResponseHelper(true, 'Logout Success', 200))->get();
            }
            return (new ResponseHelper(false, 'Logout Failed', 400))->get();
        } catch (\Exception $ex) {
            return (new ResponseHelper(false, 'Internal Server Error', 500))->get();
        }
    }




}
