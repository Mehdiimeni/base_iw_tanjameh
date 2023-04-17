<?php

/**
 * Summary of Router
 */
class Router extends GlobalVarTools
{
    public function __construct()
    {
        parent::__construct();
        

    }


    /**
     * Summary of icore
     * @param mixed $base_root
     * @return string
     */
    public  function icore($base_root)
    {
        if (parent::JsonDecode(parent::ServerVarToJson())->HTTP_HOST == 'localhost') {
            return $base_root . "/icore";

        } else {

            return $this->Icore;

        }


    }
}