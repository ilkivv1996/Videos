<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apikey extends Model
{
    protected $table = 'apikeys';

    public function getListApiKey(){
        return $this->where('active', 1)->pluck('key');
    }

    public function renameApiKey(){
        return $this->where('active', 1)->pluck('key');
    }

    public function getFirstApiKey($key){
        return $this->where('key', $key)->first();
    }

    public function getFalseApiKey(){
        return $this->where('active', 0)->get();
    }


}
