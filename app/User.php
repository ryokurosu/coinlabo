<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Denpa\Bitcoin\Client as BitcoinClient;
use Config;
use PragmaRX\Google2FA\Google2FA;


class User extends Authenticatable
{
    use Notifiable;
    private $bitcoind;

    public function __construct($attributes = array(), $exists = false)
    {
      parent::__construct($attributes, $exists);

      $this->bitcoind = new BitcoinClient([
        'scheme' => 'http',                 
        'host'   => Config::get('services.bitcoin.host'),            
        'port'   => Config::get('services.bitcoin.port'),                   
        'user'   => Config::get('services.bitcoin.user'),              
        'pass'   => Config::get('services.bitcoin.pass'),          
    ]);
  } 


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active','code' ,'email_token','verified','address','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function activate(){
        $this->active = 1;
        $this->save();
    }


    public function inactivate(){
        $this->active = 0;
        $this->save();
    }

    public function verified()
    {
        $this->email_token = null;
        $this->verified = 1;
        $this->save();
    }

    public function articles(){
        return $this->hasMany('App\Article');
    }

    public function sumValue(){
        return $this->articles()->count('sum');
    }

    public function blogs(){
        return $this->hasMany('App\Blog');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function isAdmin(){
        if($this->auth == 2){
            return true;
        }else{
            return false;
        }
    }

    public function getbalance(){
        return $this->bitcoind->getbalance($this->code)->get();
    }

    public function getaddress(){
        return $this->bitcoind->getaccountaddress($this->code)->get();
    }

    public function sendToAddress($toUserId,$amount = 0.00001,$comment = 'coinlaboでの取引'){
        $toUser = self::active()->findOrFail($toUserId);
        return $this->bitcoind->move($this->code,$toUser->code,$amount,0,$comment);
    }

    public function getnewaddress(){
     return $this->bitcoind->getnewaddress($this->code)->get();
 }

 public function setGoogle2FA($secretKey){
    $this->google2fa_secret = $secretKey;
    $this->google2fa = 1;
    $this->save();
    return $this->google2fa_secret;
}

public function verifyGoogle2FA($secret){
    $google2fa = new Google2FA();
    $valid = $google2fa->verifyKey($this->google2fa_secret, $secret);
    return $valid;
}

public function disableGoogle2FA(){
    $this->google2fa_secret =  '';
    $this->google2fa = 0;
    return $this->save();
}

public function checkGoogle2FA(){
    return $this->google2fa == 1;
}

}
