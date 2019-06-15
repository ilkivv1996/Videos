<?php

namespace App\Console\Commands;

use App\Video;
use Illuminate\Console\Command;
use App\Sitemap;
use App\Setting;
use DateTime;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\While_;
use SimpleXMLElement;

class SitemapGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generation Sitemap.xml';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Video $vd, Setting $stn) // заполняем все файлы sitemap
    {
        /* на продакшене нужно заменить переменную $site_url на закоменченную*/
        $site_url = $stn->getItem('site_url')->value; //получаем url сайта
        //$site_url = url('/');
        Log::info($site_url);
        $base = '<?xml version="1.0" encoding="UTF-8"?>
            <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
            </urlset>';
        //$vd = new Video();
        $videos = $vd->getVideoList(); //получаем ссылки на все видео
        $limit = 50;
        $this->clear(); // чистим таблицу
        if(count($videos) < $limit){
            $limit = count($videos);
        }
        for($i = 0; $i < count($videos) / $limit; $i++){ // смотрим сколько страниц у нас получится
            $xmlbase = new SimpleXMLElement($base);
            $row  = $xmlbase->addChild("url");
            $row->addChild("loc", $site_url);
            $row->addChild("lastmod",date("c"));
            $row->addChild("changefreq","monthly");
            $row->addChild("priority","1");

            $j = $i * $limit;
            while(($j < $limit) || ($j < count($videos))){ // заполняем страницы
                //Log::info($videos[$j]->path_url);
                $row  = $xmlbase->addChild("url");
                $row->addChild("loc",$site_url.$videos[$j]->path_url);
                //$date = new DateTime($videos[$j]->created_at);
                //$row->addChild("lastmod",$date->format("Y-m-d\TH:i:sP"));
                $row->addChild("changefreq","monthly");
                $row->addChild("priority","1");
                $j++;
            }

            $xmlbase->saveXML(public_path()."/sitemap$i.xml"); // сохраняем
            $xmlbase->getName();
            //Log::info($xmlbase->xpath());
            compressReport(public_path()."/sitemap$i.xml");
            $this->save($site_url."/sitemap$i.xml"); // ссылки заносим в бд
        }
    }

    public function save($url){ // сохраняем все ссылки на карты в бд
        $sitemap = new Sitemap();
        $sitemap->url = $url;
        $sitemap->save();
    }

    public function clear(){ // очищаем таблицу
        $sitemap = new Sitemap();
        $sitemap->truncate();
    }

    function compressReport($filename) //сжимаем файл
    {
        $gz = $filename . '.gz';
        compress
    }
}
