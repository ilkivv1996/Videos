<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    public function getMenu(){// берем из тегов все уникалльные записи в рандомном порядке для меню
        return $this->inRandomOrder()->limit(20)->get();
    }

    public function getItemMenu($title){// берем из тегов все уникалльные записи в рандомном порядке для меню
        return $this->where('title', $title)->first();
    }

    public function getItemMenuToUrl($url){ // берем элемент меню по урл
        return $this->where('url', $url)->first();
    }
}
