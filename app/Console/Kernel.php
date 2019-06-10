<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Apikey;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     * нужно выполнить команду для запуска планировщика D:\OSPanel\domains\video.ru\artisan schedule:run

     *
     */
    protected function schedule(Schedule $schedule)// выполняем команды по расписанию
    {

        //$schedule->call($this->trueApiKey())->everyMinute();
        $schedule->call(function () {
            $date = Carbon::now(); // получаем текущую дату

            $apikey = new Apikey(); // создаем экземпляр класса
            $key = $apikey->getFalseApiKey(); // получаем неактивные ключи
            //Log::info($key[0]->updated_at->diffInHours($date, false));
            //Log::info(diffInHours($date, $key[0]->updated_at));
             foreach($key as $item) {
                Log::info($apikey);
                if($item->updated_at->diffInHours($date, false) >= 24){ // сравниваем текущую дату и последнее обновление, если есть сутки, то активируем
                    $pk = $apikey->getFirstApiKey($item->key); // получаем запись
                    $pk->active = 1; // делаем активной
                    $pk->save();
                }
            }
        })->everyMinute();
    }



    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    public function trueApiKey(){
        Log::info("Запуск");
        $date = Carbon::now();
        $toDateString = $date->toDateString();
        $toTimeString = $date->toTimeString();
        Log::info($toDateString);
        $apikey = Apikey::getFalseApiKey();
        /*if(){
            $apikey->active = 1;
            $apikey->save();
        }*/
    }
}
