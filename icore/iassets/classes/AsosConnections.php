<?php

class AsosConnections extends Regularization
{
    private $MainUrl;
    private $RapidapiHost;
    private $RapidapiKey;

    public function __construct()
    {
        $this->MainUrl = "https://asos2.p.rapidapi.com/";
        $this->RapidapiHost = "asos2.p.rapidapi.com";
        $this->RapidapiKey = "ae43f4cf44msh350bf21c1629509p17e169jsn8abc1ef842b0";
       // $this->RapidapiKey = "9ba7d924b1msh2e2b094b0b3f128p177015jsne09c3f6b7950";
    }

    public function StartCurl()
    {
        return curl_init();
    }

    public function CloseCurl($Curl)
    {
        curl_close($Curl);
    }

    public function ExecCurl($Curl)
    {

        if (curl_error($Curl)) {
            return "cURL Error #:" . curl_error($Curl);
        } else {
            return curl_exec($Curl);
        }
    }

    public function CategoriesList($varList = null)
    {

        $Curl = $this->StartCurl();
        curl_setopt_array($Curl, [
            CURLOPT_URL => $this->MainUrl . "categories/list?country=GB&lang=en-GB",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: " . $this->RapidapiHost,
                "x-rapidapi-key: " . $this->RapidapiKey
            ],
        ]);

        return parent::enBase64( $this->ExecCurl($Curl),0);
        $this->CloseCurl($Curl);

    }

    public function ProductsList($CatId)
    {

        $Curl = $this->StartCurl();
        curl_setopt_array($Curl, [
            CURLOPT_URL => $this->MainUrl . "products/v2/list?country=GB&lang=en-GB&store=COM&currency=GBP&offset=0&categoryId=".$CatId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: " . $this->RapidapiHost,
                "x-rapidapi-key: " . $this->RapidapiKey
            ],
        ]);

        return parent::enBase64( $this->ExecCurl($Curl),0);
        $this->CloseCurl($Curl);

    }



    public function ProductsDetail($ProductId)
    {

        $Curl = $this->StartCurl();
        curl_setopt_array($Curl, [
            CURLOPT_URL => $this->MainUrl . "products/v3/detail?id=".$ProductId."&country=GB&lang=en-GB&currency=GBP&store=COM&sizeSchema=UK",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: " . $this->RapidapiHost,
                "x-rapidapi-key: " . $this->RapidapiKey
            ],
        ]);

        return parent::enBase64( $this->ExecCurl($Curl),0);
        $this->CloseCurl($Curl);

    }

    public function ProductsListAt($CatId,  $Attribute = '',$Limit = 12)
    {

        $Curl = $this->StartCurl();
        curl_setopt_array($Curl, [
            CURLOPT_URL => $this->MainUrl . "products/v2/list?store=COM&offset=0&limit=" . $Limit . $Attribute."&country=GB&sort=freshness&currency=GBP&sizeSchema=UK&lang=en-GB&offset=0&categoryId=" . $CatId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: " . $this->RapidapiHost,
                "x-rapidapi-key: " . $this->RapidapiKey
            ],
        ]);

        return parent::enBase64($this->ExecCurl($Curl), 0);
        $this->CloseCurl($Curl);

    }

    public function getName(): string
    {
        return $this->MainUrl;
    }
}
