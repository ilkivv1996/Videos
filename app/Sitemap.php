<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sitemap extends Model
{
    protected $table = 'sitemaps';

    public function getSitemap(){
        return $this->get();
    }
}
