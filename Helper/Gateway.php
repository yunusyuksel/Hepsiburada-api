<?php


namespace Swe\Hepsiburada\Helper;

use Swe\Hepsiburada\Helper\HepsiburadaException;
class Gateway
{

    /**
     *
     * @description Hepsiburada Api Key
     *
     */

    public $apiKey;


    /**
     *
     * @description Hepsiburada Api Secret
     *
     */

    public $apiSecret;


    /**
     *
     * @description Hepsiburada Api Test Mode
     *
     */

    public $apiTestMode;



    protected $services = [
        'category' => 'CategoryService',
        'product' => 'ProductService'
    ];

    public function __get($name){
        if(!isset($this->services[$name])){
            throw new HepsiburadaException("Invdalid Service");
        }

        if(isset($this->$name)){
            return $this->$name;
        }

        $this->$name = $this->createServiceInstance($this->services[$name]);
        return $this->$name;
    }

    protected function createServiceInstance($serviceName){
        $serviceName = "Swe\Hepsiburada\Services\\" . $serviceName;

        if(!class_exists($serviceName)){
            throw new \Swe\Hepsiburada\Helper\HepsiburadaException("Invalid Service");
        }

        return new $serviceName($this->apiKey,$this->apiSecret,$this->apiTestMode);
    }
}
