<?php


namespace Swe\Hepsiburada\Helper;


class Request
{

    public $apiTestMode = false;

    public $apiUrl;

    protected $apiKey;
    protected $apiSecret;
    protected $method;

    protected $data = [];

    public function __construct($apiUrl,$apiKey,$apiSecret,$testMode,$method = "GET"){
        $this->setApiKey($apiKey);
        $this->setApiSecret($apiSecret);
        $this->setApiUrl($apiUrl);
        $this->setMethod($method);


    }

    public function setApiKey($key)
    {
        $this->apiKey = $key;
    }

    /**
     *
     * API Şifresini değiştirir.
     *
     * @param string $apiUrl
     *
     */
    public function setApiSecret($secret)
    {
        $this->apiSecret = $secret;
    }

    public function setApiUrl($apiUrl)
    {
        if ($this->apiTestMode) {
            return;
        }
        $this->apiUrl = $apiUrl;
    }

    public function setMethod($method)
    {
        $this->method = strtoupper($method);
    }

    protected function authorization()
    {
        return base64_encode($this->apiKey . ':' . $this->apiSecret);
    }

    public function getResponse($query, $data, $authorization = true)
    {

        $requestData = Format::initialize($query, $data);
        $ch = curl_init();
        $header = [];
        curl_setopt($ch, CURLOPT_URL, $this->getApiUrl($requestData));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent());

        if ($authorization) {
            $header[] = 'Authorization: Basic ' . $this->authorization();
        }

        if ($this->method == 'POST') {
            $header[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
        $response = trim(curl_exec($ch));
        if (empty($response)) {
            throw new TrendyolException("Trendyol boş yanıt döndürdü.");
        }

        $response = json_decode($response);
        curl_close($ch);
        return $response;
    }

}
