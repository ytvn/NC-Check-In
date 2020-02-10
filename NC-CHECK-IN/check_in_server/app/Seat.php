<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    public function room()
    {
        return $this->belongsTo("App\Room");
    }

    public function delegate()
    {
        return $this->belongsTo("App\Delegate");
    }

    public function activities()
    {
        return $this->hasMany("App\Activity", "delegate_id", "delegate_id")->where("room_id", $this->room_id);
    }
}
