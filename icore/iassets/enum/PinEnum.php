<?php

use MyCLabs\Enum\Enum;

class PinEnum extends Enum
{
    public const CellOperator = array('Irmci'=>'همراه اول', 'Irancell'=>'ایرانسل', 'Taliya'=>'تالیا', 'Rightel'=>'رایتل');
    public const PinType = array('10000'=>10000, '20000'=>20000, '50000'=>50000, '100000'=>100000,'200000'=>200000);

}