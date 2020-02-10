<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delegate extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;
    
    public static function getInfo(){
        return response()->json(Delegate::select('name', 'student_id')->first());
    }

    public function activities()
    {
        return $this->hasMany("App\Activity");
    }
}
