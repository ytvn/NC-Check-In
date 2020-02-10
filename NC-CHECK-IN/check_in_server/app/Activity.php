<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public function seat()
    {
        return $this->belongsTo("App\Seat", "delegate_id", "delegate_id")->where('room_id',$this->room_id);
    }

    public function delegate()
    {
        return $this->belongsTo("App\Delegate");
    }
}
