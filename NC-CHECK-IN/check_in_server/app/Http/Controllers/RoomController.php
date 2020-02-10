<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::all();

        $viewParams = [
            "rooms" => $rooms,
        ];
        
        return view("room/roomList", $viewParams);
    }

    public function activate(Request $request)
    {
        $room = $request->input("room-id");

        try{
            $room = decrypt($room);
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'The selected room is invalid');
        }

        $room = Room::find($room);

        if(!$room){
            return redirect()->back()->with('error', 'The selected room is not exist');
        }

        //Clear all activated room
        Room::where("active", true)->update(["active" => null]);
        $room->active = true;
        $room->save();

        return redirect("room")->with('message', 'The room "' . $room->name .'" is activated');
    }

    public function deactivate(Request $request)
    {
        $room = $request->input("room-id");

        try{
            $room = decrypt($room);
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'The selected room is invalid');
        }

        $room = Room::find($room);

        if(!$room){
            return redirect()->back()->with('error', 'The selected room is not exist');
        }

        $room->active = null;
        $room->save();

        return redirect("room")->with('message', 'The room "' . $room->name .'" is deactivated');
    }

    public function clear(Request $request)
    {
        $room = $request->input("room");
        try{
            $room = decrypt($room);
        }catch(\Exception $e){
            return ["success" => false];
        }

        $room = Room::find($room);
        if(!$room){
            return ["success"=>false];
        }

        $room->seats()->update(["state" => false]);
        $room->activities()->delete();

        return ["success"=>true];
    }
}
