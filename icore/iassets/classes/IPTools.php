<?php

class IPTools extends GlobalVarTools
{
    public $jsonServerVar;
    private $DefineRoot;

    public function __construct($DefineRoot)
    {
        parent::__construct();
        $this->jsonServerVar = parent::JsonDecode(parent::ServerVarToJson());
        $this->DefineRoot = $DefineRoot;

        $this->FindHostAllow();
        $this->FindIPAllow();
        $this->FindIPDeny();
    }

    public function getUserIP()
    {
        $client = @$this->jsonServerVar->HTTP_CLIENT_IP;
        $forward = @$this->jsonServerVar->HTTP_X_FORWARDED_FOR;
        $remote = @$this->jsonServerVar->REMOTE_ADDR;
        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        return $ip;
    }

    public function getHostAddressLoad()
    {
        return $this->jsonServerVar->HTTP_HOST;
    }

    public function Destroyer()
    {
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        session_destroy();
    }

    public function Reloader()
    {
        header("location: https://borobe.com");
        exit();
    }

    public function getHostAllow()
    {
        return array_map('trim', (array)file($this->DefineRoot . 'conf/host.iw'));
    }

    public function getIPAllow()
    {

        return array_map('trim', (array)file($this->DefineRoot . 'conf/ipallow.txt'));
    }

    public function getIPDeny()
    {
        return array_map('trim', (array)file($this->DefineRoot . 'conf/ipdeny.txt'));
    }

    public function FindHostAllow()
    {


        if (!in_array($this->getHostAddressLoad(), $this->getHostAllow())) {

            $this->Destroyer();
            echo(11111);
            //$this->Reloader();
        }

    }

    public function FindIPAllow()
    {
        if (!in_array($this->getUserIP(), $this->getIPAllow()) and !in_array('all', $this->getIPAllow())) {
            $this->Destroyer();
            echo(111112222);
            //$this->Reloader();
        }

    }

    public function FindIPDeny()
    {

        if (in_array($this->getUserIP(), $this->getIPDeny()) and !in_array('any', $this->getIPDeny())) {
            echo(4665);

            $this->Destroyer();
            //$this->Reloader();
        }
    }


}
