<?php

namespace App\Console;

use http\Client;
use http\Env;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
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
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function (){
            $vk = new VkClient\Client();
            $count=10;
            $request=new VkClient\Request();
            $responseGroup1 = $vk->groups()->getById(Env::VK_TOKEN,array(
                'group_ids' => 'urfumemes'));
            $response = $vk->wall()->get(Env::VK_TOKEN,array(

                'owner_id' => -$responseGroup1[0]['id'],'offset'=>1,'count'=>$count));
        })->hourly();
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
