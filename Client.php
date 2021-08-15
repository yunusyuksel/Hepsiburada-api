<?php


namespace Swe\Hepsiburada;


use Swe\Hepsiburada\Helper\Gateway;

class Client extends Gateway
{

    public function setApiKey($key){
        $this->apiKey = $key;
    }

    public function setApiSecret($secret){
        $this->apiSecret = $secret;
    }

    public function setTestMode($testMode=false){
        $this->apiTestMode = $testMode;
    }

}
