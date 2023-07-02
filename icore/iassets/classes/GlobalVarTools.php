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
        return json_encode($this->AllGet);
    }

    public function GetVarToJsonNoSet()
    {
        
        return json_encode($_GET);
    }

    public function ServerVarToJson()
    {

        return json_encode($this->AllServer);
    }

    public function SessionVarToJson()
    {
        return json_encode($this->AllSession);
    }

    public function getIWVarToJson($name)
    {
        if (json_encode(@$this->AllCookie[$name]) != null) {
            $this->setSessionVar($name, $this->de2Base64(@$this->AllCookie[$name]));
            return json_encode($this->de2Base64(@$this->AllCookie[$name]));
        } elseif (json_encode($this->AllSession[$name]) != null) {
            $this->setCookieVar($name, $this->AllSession[$name]);
            return json_encode($this->AllSession[$name]);
        } else {
            return null;
        }

    }

    public function CookieVarToJson()
    {
        return json_encode($this->AllCookie);
    }

    public function PostVarToJson()
    {
        return json_encode($this->AllPost);
    }

    public function FileVarToJson()
    {
        return json_encode($this->AllFiles);
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
