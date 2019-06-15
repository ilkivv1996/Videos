<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sitemap;

class SitemapController extends Controller
{
    public function sitemapIndex(Sitemap $sm){
        $this->data['sitemaps'] = $sm->getSitemap();
        return response()->view('particals.sitemap', $this->data)->header('Content-type', 'text/xml');
    }
}
