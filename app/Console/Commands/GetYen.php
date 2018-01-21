<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use App\Coin;
use Exception;

class GetYen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:yen {coin?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'getyen description';

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
        $coin = $this->argument('coin');

        if(is_null($coin)){
            $coins = Coin::all();
        }else{
             /*
            どの表現にも対応させる
            名前、単位、エイリアス(bitcoin,rippleとか)
             */
            $coins = Coin::where('name',$coin)->orWhere('unit',$coin)->orWhere('alias',$coin)->get();
        }

        foreach($coins as $c){
            $this->updateRate($c);
        }

    }

    private function updateRate($coin){
        try{
            $alias = $coin->alias;
          $url="https://api.coinmarketcap.com/v1/ticker/$alias/?convert=jpy";

          $data = file_get_contents($url);
          $data = json_decode($data);
          $yen = $data[0]->price_jpy;
          $coin->fill(['per' => $yen])->save();
          return $coin;
      }catch (Exception $e){
        echo $e->getLine().":".$e->getMessage()."\n";
        return false;
    }
}
}
