<?php

class PricingTools extends DBORM
{
    public function __construct($dbConnection)
    {
        parent::__construct($dbConnection);
    }

    public function Pricing($PIdKey)
    {
        $SCondition = " IdKey = '$PIdKey' ";
        parent::FetchAll($SCondition,'');

    }
}