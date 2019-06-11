<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Video extends Model
{
    protected $table = 'videos';

    public function getVideoList(){ // получаем список видео из бд
        return $this->get();
    }

    public function getVideo($url){ // получаем определенное видео при переходе по ссылке
        return $this->where('link', $url)->firstOrFail();
    }

    public function getVideoCategory($url){ // получаем список видео по определенному тегу
        return $this->where('tags', $url)->get();
    }

    public function getRandom($tags, $limit){ // получаем список видео из бд
        return $this->where('tags', $tags)->inRandomOrder()->limit($limit)->get();
    }

    public function getLiken($title){ // сравниваем с полученным списком, если есть не сохраняем, чтобы дублей не было
        return $this->where('title', $title)->first();
    }

    /*public function getUploadVideos($video){
        return $this->where('video', $video)->get();
    }*/

    public function getSearch($search){
        return $this->where('title', 'like', '%'. $search . '%')->get();
    }
}
