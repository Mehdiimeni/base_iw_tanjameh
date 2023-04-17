<?php

class GlobalVarTools extends Regularization
{
    public $AllRequest;
    public $AllGet;
    public $AllPost;
    public $AllSession;
    public $AllFiles;
    public $AllCookie;
    public $AllServer;

    public function __construct()
    {
        $this->AllRequest = $_REQUEST;
        $this->AllGet = $_GET;
        $this->AllPost = $_POST;
        $this->AllSession = $_SESSION;
        $this->AllFiles = $_FILES;
        $this->AllCookie = $_COOKIE;
        $this->AllServer = $_SERVER;

    }

    public function GetVarToJson()
    {
        return $this->JsonEncode($this->AllGet);
    }

    public function GetVarToJsonNoSet()
    {
        
        return $this->JsonEncode($_GET);
    }

    public function ServerVarToJson()
    {
        return $this->JsonEncode($this->AllServer);
    }

    public function SessionVarToJson()
    {
        return $this->JsonEncode($this->AllSession);
    }

    public function getIWVarToJson($name)
    {
        if ($this->JsonEncode($this->AllCookie[$name]) != null) {
            $this->setSessionVar($name, $this->de2Base64($this->AllCookie[$name]));
            return $this->JsonEncode($this->de2Base64($this->AllCookie[$name]));
        } elseif ($this->JsonEncode($this->AllSession[$name]) != null) {
            $this->setCookieVar($name, $this->AllSession[$name]);
            return $this->JsonEncode($this->AllSession[$name]);
        } else {
            return null;
        }

    }

    public function CookieVarToJson()
    {
        return $this->JsonEncode($this->AllCookie);
    }

    public function PostVarToJson()
    {
        return $this->JsonEncode($this->AllPost);
    }

    public function FileVarToJson()
    {
        return $this->JsonEncode($this->AllFiles);
    }


    public function setSessionVar($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function setCookieVar($name, $value)
    {
        if ($name == '_IWAdminIdKey'){
            setcookie($name, $value, time() + 86400 , '/');
        }else{
            setcookie($name, $value, time() + 3600, '/');
        }

        $_COOKIE[$name] = $value;
    }

    public function setCookieVarUserNull($name)
    {
        unset($_COOKIE[$name]);
        setcookie($name, null, -1, '/');
    }

    public function setGetVarNull()
    {
        $this->AllGet = null;
    }

    public function UnsetGetVar(array $names)
    {
        foreach ($names as $name)
            unset($this->AllGet[$name]);

        $this->setGetVar('', '');
    }

    public function JustUnsetGetVar(array $names)
    {
        foreach ($names as $name)
            unset($this->AllGet[$name]);
    }

    public function setGetVar($name, $value, $unset = null): string
    {
        if ($unset != null)
            $this->JustUnsetGetVar($unset);

        if ($name == '') {
            return '?' . http_build_query($this->AllGet);
        } else {

            if ($this->AllGet == null) {
                return '?' . $name . '=' . $value;
            } else {

                $this->AllGet[$name] = $value;
                return '?' . http_build_query($this->AllGet);
            }

        }
    }

    public function RefFormGet()
    {
        return explode("::==::", $this->de2Base64(@$this->JsonDecode($this->GetVarToJsonNoSet())->ref));
    }


}
