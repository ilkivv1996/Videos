<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'def_settings';

    public function getItem($name){
        return $this->where('name', $name)->firstOrFail();
    }
}
