<?php

class MakeDirectory
{
    public function MKDir($FullAddress,$Name,$Permission)
    {
        if (!file_exists($FullAddress.$Name)) {
            mkdir($FullAddress.$Name, $Permission, true);
        }
    }
}
