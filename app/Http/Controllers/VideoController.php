<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use App\Apikey;
use Mockery\Exception;
use App\Menu;
class VideoController extends Controller
{

    function __construct(Menu $menu)
    {
        $this->data = [];
        $this->data['menu'] = $menu->getMenu(); // вывводим меню

    }

    public function index(Video $vd, Apikey $pk, Menu $menu){ // главная страница
        $search = ["как сделать", "про футбол", "лайфхаки", "мстители", "годзила", "человек-паук", "телефоны", "php", "java", "гонки"]; //  Поисковый запрос
        //$search = ["xiaomi", "как сделать"];
        $limit = 5; // Количество записей на запрос
        $apikey = $pk->getListApiKey(); // получаем список активных ключей

        /*if(!isset($apikey)){
            echo "Закончились ключи";
        }else{
            $this->search_key($vd, $pk, $menu, $apikey, $search, $limit); // поиск видео
        }*/

        return view('particals.index', $this->data); // показываем на главной
    }

    public function search_key($vd, $pk, $menu, $apikey, $search, $limit){ // запись в массив видео по ключевым фразам
        $res = [];
            for ($i = 0; $i < count($search); $i++) {
                $this->save_menus($search[$i], $menu);
                $result = $this->search_youtube($vd,$pk, $search[$i], $apikey, $limit);
                if ($result == "0") {
                    echo "превышен лимит запросов";
                    break;
                } else {
                    $res[$i] = $result;
                }
            }
            return $res;
    }

    /*public function list_youtube(Video $vd){ // Выводим список видео
        $this->data['videos'] = $vd->getVideoList();
        return view('particals.videos', $this->data);
    }*/

    public function video_category($url, Video $vd, Menu $menu){ // получаем список видео определенной категории по соответствующему тегу
        $this->data['category'] = $menu->getItemMenuToUrl($url); // берем элемент меню по урл
        //dd($per);
        $this->data['videos'] = $vd->getVideoCategory($this->data['category']->title); // фильтруем видео по полученному теги
        //dd($this->data);
        return view('particals.videos_category', $this->data);
    }

    public function video($url1, $url2, Video $vd){ // Выводим список видео
        //$this->data['category'] = $menu->getItemMenuToUrl($url1); //получаем категорию
        $this->data['url1'] = $url1;
        $this->data['video'] = $vd->getVideo($url2);
        $limit = 6;
        //dd($video->tags);
        $this->data['random'] = $vd->getRandom($this->data['video']->tags, $limit);
        return view('particals.video', $this->data);
    }

    public function search_youtube($vd, $pk, $search, $apikey, $limit){ // ищем видеоролики по каждому запросу
        //dd($apikey);
        $tags = $search;
        $search =  urlencode($search); // заменяем пробелы на проценты
        $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&q=$search&maxResults=$limit&type=video&regionCode=RU&key=$apikey[0]";
            //dd($search);
            //dd($url);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,        FALSE);
            curl_setopt($ch, CURLOPT_HEADER,                FALSE);
            curl_setopt($ch, CURLOPT_URL,                   $url);
            curl_setopt($ch, CURLOPT_REFERER,               $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,        TRUE);
            $out = curl_exec($ch);
            curl_close($ch);
            $res = json_decode($out);
            //dd($res);
            if(!isset($res->error->code)) { // проверяем на существование ошибки 403
                for ($i = 0; $i < count($res->items); $i++) {
                    if (!$vd->getLiken($res->items[$i]->snippet->title)) { // исключаем дубли
                        $this->save_video($res->items[$i]->snippet->title, $res->items[$i]->id->videoId, $tags, $res->items[$i]->snippet->thumbnails->medium->url);// сохраняем полученные видео в бд
                    }
                }
                return $res; // получаем json с данным
            }else{
                //dd($apikey);
                if(count($apikey) > 1){
                    $apikey->shift();
                    $this->update_key($pk, $apikey[0]);
                    return $this->search_youtube($vd, $pk, $search, $apikey[0], $limit);
                }elseif (count($apikey) == 1){
                    //dd($apikey);
                    $this->update_key($pk, $apikey[0]);
                    return 0;
                }
            }
    }

    public function save_video($title, $video, $tags, $img){ // сохраняем полученные видео в бд
        $vd = new Video();
        $vd->title = $title;
        $vd->h1 = $title;
        $vd->url = $this->translit($title);
        $vd->path_url = $this->translit($tags) . '/' .$this->translit($title);
        $vd->video = $video;
        $vd->tags = $tags;
        $vd->img = $img;
        $vd->save();
    }

    public function save_menus($title, $menu){ // сразу сохраняем полученные теги в меню
        $per = $menu->getItemMenu($title);
        if(empty($per)){ // проверяем есть ли такой элемент меню, если нет то добавляем
            $menu = new Menu();
            $menu->title = $title;
            $menu->url = $this->translit($title);
            $menu->save();
        }

    }

    public function update_key($pk, $key){ // делаем ключ неактивный
        $apikey = $pk->getFirstApiKey($key);
        $apikey->active = 0;
        $apikey->save();
    }

    public function translit($link){ // делаем чпу
        $link = strip_tags($link); // убираем HTML-теги
        $link = str_replace(array("\n", "\r"), " ", $link); // убираем перевод каретки
        $link = preg_replace("/\s+/", ' ', $link); // удаляем повторяющие пробелы
        $link = trim($link); // убираем пробелы в начале и конце строки
        $link = function_exists('mb_strtolower') ? mb_strtolower($link) : strtolower($link); // переводим строку в нижний регистр (иногда надо задать локаль)
        $link = strtr($link, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
        $link = preg_replace("/[^0-9a-z-_ ]/i", "", $link); // очищаем строку от недопустимых символов
        $link = str_replace(" ", "-", $link); // заменяем пробелы знаком минус
        return $link; // возвращаем результат

    }

    public function search(Request $request, Video $vd){
        $this->data['search'] = $vd->getSearch($request->search);
        //dd($this->data['search']);
        return view('particals.search_result', $this->data);
    }
}
