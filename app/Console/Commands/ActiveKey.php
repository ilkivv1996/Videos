<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Apikey;
use Carbon\Carbon;

class ActiveKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activekey';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle(Apikey $pk, Carbon $carbon)
    {
        $date = $carbon->now(); // получаем текущую дату

        //$apikey = new Apikey(); // создаем экземпляр класса
        $key = $pk->getFalseApiKey(); // получаем неактивные ключи
        foreach($key as $item) {
            if($item->updated_at->diffInHours($date, false) >= 24){ // сравниваем текущую дату и последнее обновление, если есть сутки, то активируем
                $pk = $pk->getFirstApiKey($item->key); // получаем запись
                $pk->active = 1; // делаем активной
                $pk->save();
            }
        }
    }

}

