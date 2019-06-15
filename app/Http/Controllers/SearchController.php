<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use App\Video;

class SearchController extends IndexController
{
    public function search(Request $request, Video $vd){ // поиск
        $this->data['search'] = $vd->getSearch($request->search);
        //dd($this->data['search']);
        return view('particals.search_result', $this->data);
    }
}
