<?php

namespace App\Classes;

use App\Helper\Common;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class UserClass
{
    private $userManager;
    public function __construct(User $user)
    {
        $this->userManager = $user;
    }


//    public function getProfile(){
//        try {
//            $email = Common::AuthID();
//            $data = $this->userManager->getProfile($email);
//            if (isset($data) && !empty($data)){
//                return response()->json(["status" => true, "message" => "profile get success","data"=>$data])->setStatusCode(200);
//            }
//        }catch (\Exception $ex){
//            Log::info("UserClass Error", ["getProfile" => $ex->getMessage(), "line" => $ex->getLine()]);
//            return response()->json(["status" => false, "message" => "internal server Error"])->setStatusCode(500);
//        }
//    }
//    public function updateProfileInformation($email,$name){
//        try {
//            $update_status = $this->userManager->updateProfileInformation($email,$name);
//            if ($update_status){
//                return response()->json(['status' => true, 'message' => 'profile information update success'])->setStatusCode(200);
//            }
//            return response()->json(['status' => false, 'message' => 'Profile Up to Date'])->setStatusCode(400);
//        } catch (\Exception $ex) {
//            Log::info('UserClass Error', ['updateProfileHeadline' => $ex->getMessage(), 'line' => $ex->getLine()]);
//            return response()->json(['status' => false, 'message' => 'internal server error'])->setStatusCode(500);
//        }
//    }

//
//    public function getUserInfo(){
//        try {
//            $email = Common::AuthID();
//            $data = $this->userManager->getUserInfo($email);
//            if (isset($data) && !empty($data)){
//                return response()->json(["status" => true, "message" => "profile get success","data"=>$data])->setStatusCode(200);
//            }
//        }catch (\Exception $ex){
//            Log::info("UserClass Error", ["getProfile" => $ex->getMessage(), "line" => $ex->getLine()]);
//            return response()->json(["status" => false, "message" => "internal server Error"])->setStatusCode(500);
//        }
//    }
}
