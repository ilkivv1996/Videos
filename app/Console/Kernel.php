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
        'App\Console\Commands\SitemapGenerate', //добавили нашу команду
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
        //$schedule->command('sitemap')->dailyAt('01:00');
        $schedule->command('sitemap')->dailyAt('01:00'); // генерация sitemap раз в сутки в час ночи
        $schedule->command('sitemap')->everyMinute();

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


}
