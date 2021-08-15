<?php


namespace Swe\Hepsiburada\Services;


use Swe\Hepsiburada\Helper\Request;

class CategoryService extends Request
{

    public $apiUrl = 'https://mpop-sit.hepsiburada.com/product/api/categories/get-all-categories';

    public function __construct($apiKey, $apiSecret,$testmode)
    {
        parent::__construct($this->apiUrl,$apiKey,$apiSecret,$testmode);
    }


    public function getCategories(){
        $this->setApiUrl($this->apiUrl);
        return $this->getResponse(true,true,false);
    }



}
