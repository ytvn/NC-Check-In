<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\Activity;

class DashboardController extends Controller
{
    public function statistic()
    {
        $activatedRoom = Room::with("seats", "delegates")->where("active", true)->first();
        if(!$activatedRoom){
            return view('room/noActivatedRoom');
        }

        $delegatesByFaculty = [];
        foreach ($activatedRoom->seats as $seat) {
            if (!array_key_exists($seat->delegate->faculty, $delegatesByFaculty)){
                $delegatesByFaculty[$seat->delegate->faculty] = collect();
            }

            $delegatesByFaculty[$seat->delegate->faculty]->push($seat);
        };

        return view('dashboard/statistic', ["room"=>$activatedRoom, "delegatesByFaculty"=>$delegatesByFaculty]);
    }
}
