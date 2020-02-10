<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Delegate;
use App\Activity;
use App\PassCode;
use App\Room;
use App\Seat;

class CheckInController extends Controller
{
    public function checkIn(Request $request){
        $type = $request->input('TYPE');
        $id = $request->input("ID");
        $passcode = $request->input("PASSCODE");
        
        //Validate the passcode
        $passcode = PassCode::where("pass_code",$passcode)->first();
        if(!$passcode){
            return ["status" => "fail",
                    "html"=>view("apiCheckinResponse/error",["message"=>"The passcode is invalid or expired"])->render()
                ];
        }

        //Check if room for check-in is opened
        $activatedRoom = Room::where("active", true)->first();
        if(!$activatedRoom){
            return ["status" => "fail",
                    "html"=>view("apiCheckinResponse/error",["message"=>"Không có hoạt động nào mở để điểm danh"])->render()
                ];
        }

        //Validate the delegate
        $seat = Seat::where("delegate_id", $id)->where("room_id", $activatedRoom->id)->first();
        if(!$seat){
            return ["status" => "fail",
                    "html"=>view("apiCheckinResponse/error",["message"=>"Phiên hiện tại không có đại biểu này"])->render()
                ];
        }

        //Check delegate state
        if($seat->state && $type=="IN"){
            return ["status" => "fail",
                    "html"=>view("apiCheckinResponse/error",["message"=>"Đại biểu đang ở trong phòng", "title"=>"Điểm danh vào thất bại"])->render(),
                ];
        }elseif (!$seat->state && $type=="OUT"){
            return ["status" => "fail",
                    "html"=>view("apiCheckinResponse/error",["message"=>"Đại biểu không ở trong phòng", "title"=>"Điểm danh ra thất bại"])->render(),
                ];
        }

        //Create a new check-in activity
        $activity = new Activity;
        $activity->delegate_id = $id;
        $activity->status = $type;
        $activity->room_id = $activatedRoom->id;
        $activity->passcode = $id;
        $activity->save();

        //Update seat state
        $seat->state = $type == "IN" ? true : false;
        $seat->save();

        return [
            "status" => "success",
             "html"=>view("apiCheckinResponse/success",
                            [
                                "name" => $seat->delegate->name,
                                "faculty" => $seat->delegate->faculty,
                                "seat" => $seat->seat,
                                "room" => $activatedRoom
                             ])->render(),
        ];
    }

    public function checkPassCode(Request $request){
        $passcode = $request->input('PASSCODE');
        
        $passcode = PassCode::where("pass_code",$passcode)->first();
        if(!$passcode){
            return 0;
        }

        return 1;
    }


}