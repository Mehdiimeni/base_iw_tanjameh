<?php
class IAPI
{

    public $MainUrl;
    public $Type;
    public $GeneralRoute;

    public $LocalName;

    public function __construct($MainUrl, $Type)
    {

        $this->MainUrl = $MainUrl;
        $this->Type = $Type;
        $this->GeneralRoute = '/icore/apis/';

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

    public function SetLocalProjectName($project_local_name)
    {
        if (str_contains($this->MainUrl, 'localhost')) {
            $this->LocalName = '/' . $project_local_name;
        } else {
            $this->LocalName = null;
        }


    }

    public function GetGeneralApi($api_url)
    {

        $filds = array('url' => $this->MainUrl . $this->LocalName,'protecol' => 'https://');
        $Curl = $this->StartCurl();

        curl_setopt_array($Curl, [
            CURLOPT_URL => $this->MainUrl . $this->LocalName . $this->GeneralRoute . $this->Type . '/' . $api_url . '.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($filds),
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
        ]);

        $this->CloseCurl($Curl);
        return $this->ExecCurl($Curl);

    }

    public function GetPostApi($api_url, $filds)
    {


        $Curl = $this->StartCurl();
        curl_setopt_array($Curl, [
            CURLOPT_URL => $this->MainUrl . $this->LocalName . $this->GeneralRoute . $this->Type . '/' . $api_url . '.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($filds),
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

        ]);

        $this->CloseCurl($Curl);
        return $this->ExecCurl($Curl);

    }


}