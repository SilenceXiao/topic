<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    protected $table = 'statuses';
    
    //反向一对多
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
