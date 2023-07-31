<?php

class Regularization
{
    public $PersianNumber;
    public $EnglishNumber;

    public function __construct()
    {
    }

    public function strReplace($String, $Selected, $Replace = ""): string
    {
        return str_replace($Selected, $Replace, $String);
    }

    public function NumberFormat($Number, $Decimals = 2, $Separator = ".", $ThousandSeparator = ",")
    {
        return number_format($Number, $Decimals, $Separator, $ThousandSeparator);
    }

    public function Nu2EN($String): string
    {
        return str_replace(array("۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"), array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9"), $String);
    }

    public function Nu2FA($String): string
    {
        return str_replace(array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9"), array("۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"), $String);
    }

    public function getUrlEncode($String)
    {
        $entities = array('%20', '%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%23', '%5B', '%5D');
        $replacements = array(' ', '!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "#", "[", "]");
        return str_replace($entities, $replacements, $String);
    }

    public function getUrlDecode($String)
    {
        $entities = array('%20', '%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%23', '%5B', '%5D');
        $replacements = array(' ', '!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "#", "[", "]");
        return str_replace($replacements, $entities, $String);
    }

    public function JsonEncode($String)
    {

        if (($String == null) or !isset($String)) {
            return null;
        } else {
            return json_encode($String);

        }
    }

    public function JsonDecode($String)
    {
        if (($String == null) or !isset($String)) {
            return null;
        } else {
            return json_decode($String);

        }
    }

    public function JsonDecodeArray($String)
    {
        return json_decode($String, true);
    }

    public function CleanWhiteSpace($string)
    {
        return trim(preg_replace('/\s+/', ' ', $string));

    }

    public function enBase64($str, $trim): string
    {
        if ($trim)
            $str = $this->strTrim($str);
        return base64_encode($str);
    }

    public function deBase64($str)
    {
        return base64_decode($str);
    }

    public function en2Base64($str, $trim): string
    {
        if ($trim)
            $str = $this->strTrim($str);
        return base64_encode(base64_encode($str));
    }


    public function de2Base64($str)
    {

        if (!empty($str)) {
            return base64_decode(base64_decode($str));
        } else {
            return null;
        }

    }

    public function mdShal($str, $trim): string
    {
        if ($trim)
            $str = $this->strTrim($str);
        return sha1(md5($str));
    }

    public function strTrim($str): string
    {
        return trim($str);
    }

    public function IdKey()
    {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 15; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return hash('crc32b', strtotime(date("Y-m-d H:i:s")) . rand(1000, 9999) . $randomString);
    }

    public function CleanStr($str)
    {
        $str = $this->strTrim($str);
        $str = strip_tags($str);
        $str = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $str);

        return $this->CleanWhiteSpace($str);
    }

    public function CleanUrlDirMaker($str)
    {
        $str = $this->strTrim($str);
        $str = strip_tags($str);
        $str = preg_replace('/<script\b[^>]*>(.*?)<\/script>/', "###", $str);
        $str = preg_replace('/[^A-Za-z]/', "###", $str);
        if (strrpos($str, "###") === false) { // note: three equal signs
            return $this->CleanWhiteSpace($str);
        } else {
            return false;
        }

    }

    public function ObjectToSelectArray($Object, $ArrayKey)
    {
        $Array = (array) $Object;
        $Array = array_values($Array);

        if ($ArrayKey == null) {
            return $Array;
        } else {
            return $Array[$ArrayKey];
        }

    }

    public function ObjectJsonToSelectArray($Object, $ArrayKey)
    {
        if ($Object == null) {
            return array();
        } else {
            $Object = $this->JsonDecode($Object);
            $Array = (array) $Object;
            $Array = array_values($Array);

            if ($ArrayKey == null) {
                return $Array;
            } else {
                return $Array[$ArrayKey];
            }
        }


    }

    public function ObjectJson($Object)
    {
        $Object = $this->JsonDecode($Object);

        return $Object;


    }

    public function STR2Lower($String)
    {
        return strtolower($String);
    }

    public function STR2Upper($String)
    {
        return strtoupper($String);
    }

    public function FindArrayKey($Value, $Array, $ExportCase = null)
    {
        if ($ExportCase == 'l')
            return $this->STR2Lower(array_search($Value, $Array));
        if ($ExportCase == 'u')
            return $this->STR2Upper(array_search($Value, $Array));
    }

    public function RemoveArrayByValue($Array, $Value)
    {
        if (($key = array_search($Value, $Array)) !== false) {
            unset($Array[$key]);
        }

        return $Array;
    }

    public function FindUrlInString($String)
    {
        preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $String, $result);

        if (!empty($result)) {
            # Found a link.
            return $result['href'][0];
        }
    }

    function StrTruncate($string, $length, $dots = "...")
    {
        return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
    }

}