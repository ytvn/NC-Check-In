<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function seats()
    {
        return $this->hasMany('App\Seat');
    }

    public function delegates()
    {
        return $this->hasManyThrough(
            "App\Delegate",
            "App\Seat",
            "room_id",
            "id",
            "id",
            "delegate_id"
            );
    }

    public function activities()
    {
        return $this->hasMany("App\Activity");
    }
}
