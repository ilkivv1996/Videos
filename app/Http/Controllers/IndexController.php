<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;

class IndexController extends Controller
{
    function __construct(Menu $menu)
    {
        $this->data = [];
        $this->data['menu'] = $menu->getMenu(); // вывводим меню
    }
}
