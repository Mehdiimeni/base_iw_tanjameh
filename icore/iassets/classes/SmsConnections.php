<?php

class SmsConnections extends Regularization
{
    private $MainUrl;
    private $apiKey;
    private $ForgetKey;
    private $ResiveBasketKey;
    private $SenderNumber;

    public function __construct($SenderNumber)
    {
        $this->SenderNumber = $SenderNumber;
        $this->MainUrl = "http://ippanel.com:8080/";
        $this->apiKey = "Ggo9HmYw47LwAk-z_p70pAAC9_8CEiR4Gdy92sO_HSk=";
        $this->ForgetKey = "f7kqrfbpjnfxm43";
        $this->ResiveBasketKey = "w91t2w7iu2ym81a";

        $this->headers[] = 'Content-Type: application/json';

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

    public function ForgetSms($UserNumber, $Name, $NewPass)
    {

        $params = array(
            'apikey' => $this->apiKey,
            'pid' => $this->ForgetKey,
            'fnum' => $this->SenderNumber,
            'tnum' => $UserNumber,
            'p1' => 'name',
            'p2' => 'password',
            'v1' => $Name,
            'v2' => $NewPass
        );
        $strUrl = $this->MainUrl . "?" . http_build_query($params);

        $Curl = $this->StartCurl();
        curl_setopt_array($Curl, [
            CURLOPT_URL => $strUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);

        return $this->ExecCurl($Curl);
        $this->CloseCurl($Curl);
    }

    public function ResiveBasketSms($UserNumber, $Name, $BasketId)
    {

        $params = array(
            'apikey' => $this->apiKey,
            'pid' => $this->ResiveBasketKey,
            'fnum' => $this->SenderNumber,
            'tnum' => $UserNumber,
            'p1' => 'name',
            'p2' => 'basketid',
            'v1' => $Name,
            'v2' => $BasketId
        );

        $strUrl = $this->MainUrl . "?" . http_build_query($params);

        $Curl = $this->StartCurl();
        curl_setopt_array($Curl, [
            CURLOPT_URL => $strUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);

        return $this->ExecCurl($Curl);
        $this->CloseCurl($Curl);

    }


    public function AdminNewBasketSms($AdminNumber, $CountBasket, $BasketId)
    {

        $params = array(
            'apikey' => $this->apiKey,
            'pid' => $this->ResiveBasketKey,
            'fnum' => $this->SenderNumber,
            'tnum' => $AdminNumber,
            'p1' => 'count',
            'p2' => 'basketid',
            'v1' => $CountBasket,
            'v2' => $BasketId
        );

        $strUrl = $this->MainUrl . "?" . http_build_query($params);

        $Curl = $this->StartCurl();
        curl_setopt_array($Curl, [
            CURLOPT_URL => $strUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);

        return $this->ExecCurl($Curl);
        $this->CloseCurl($Curl);

    }

    public function getName(): string
    {
        return $this->MainUrl;
    }
}
