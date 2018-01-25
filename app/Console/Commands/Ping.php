<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;

class Ping extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ping send';

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
    public function handle()
    {

        $pings = [
            'https://www.google.com/ping?sitemap=',
            'https://www.bing.com/ping?sitemap='
        ];

        $url = url('/sitemap.xml'); 

        foreach($pings as $ping){
        $curl = curl_init($ping.urlencode($url));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET'); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        $response = curl_exec($curl);
        curl_close($curl);
    }
}
}
