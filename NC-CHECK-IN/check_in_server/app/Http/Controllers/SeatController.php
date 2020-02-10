<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Room;
use App\Activity;

class SeatController extends Controller
{
    public function seatLayout()
    {
        $activatedRoom = Room::where("active", true)->first();

        if(!$activatedRoom){
            return view('room/noActivatedRoom');
        }

        $seats = $activatedRoom->seats->keyBy("seat");
        $lastActivity = Activity::latest()->first();
        

        $viewParams = [
            "numOfRow" => $activatedRoom->num_of_rows,
            "numOfCol" => $activatedRoom->num_of_columns,
            "colsHaveSpace" => explode(",",$activatedRoom->cols_have_space_left),
            "seats" => $seats,
            "lastActivity"=> $lastActivity,
            "room" => $activatedRoom

        ];
        return view('room/seatMap', $viewParams);
    }

    public function seatLayoutSync(Request $request)
    {
        $lastTracking = $request->input("lastTracking");
        
        try{
            $lastTracking = decrypt($lastTracking);
        }catch(\Exception $e){
            $lastTracking = 0;
        }

        $activatedRoom = Room::where("active", true)->first();
        $activities = $activatedRoom->activities()->where("id", ">", $lastTracking)->get();

        $absentDelegates = $activatedRoom->seats()->where("state", false)->count();
        $presentDelegates = $activatedRoom->seats()->where("state", true)->count();

        if(!$activities->count()){
            return ["success"=>true, "data"=>[]];
        }

        $resultData = $activities->map(function($activity){
            return [
                "seat"=>$activity->seat->seat,
                "name" =>$activity->delegate->name,
                "faculty"=>$activity->delegate->faculty,
                "image" =>$activity->delegate->image,
                "action" => $activity->status,
            ];
        });

        return ["success"=>true, "absentDelegates" => $absentDelegates, "presentDelegates"=>$presentDelegates, "lastTracking"=>encrypt($activities->last()->id), "data"=>$resultData];
    }
}