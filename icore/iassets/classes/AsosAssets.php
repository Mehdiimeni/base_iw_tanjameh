<?php

class AsosAssets extends Regularization
{
    public function RootCaption($RootData)
    {
        $arrCaption = array();
        foreach ($RootData as $data) {
            $arrCaption[] = $data['content']['title'];
                            $strTitle = str_replace('"', "", $strTitle);
                            $strTitle = str_replace("'", "", $strTitle);
        }
        return parent::JsonEncode($arrCaption);
    }

    public function RootContent($RootData)
    {
        return ($RootData['children']);
    }

}
