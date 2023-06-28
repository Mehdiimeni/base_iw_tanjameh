<?php

class ShowFile extends StorageTools
{
    public function __construct($MainName)
    {
        parent::__construct($MainName);
    }

    public function ShowImage($strRootStart, $FileGrAddress, $FileName, $FileTitle, $ChSize = 0, $ImgClass = '', $ImageSrc = 'src', $WaterMark = 0, $Margin = 5, $hadjust = 0)
    {


        $repository_address = $strRootStart . $FileGrAddress;
        $repository_thumbnail_address = $repository_address . 'thumbnail/';

        

        //main file
        $FileInfoSize = parent::FindFileInfoSize($repository_address . $FileName);


        if ($FileInfoSize != null) {



            if ($ChSize == 0) {
                return ('<img ' . $ImgClass . ' ' . $ImageSrc . '="' . $repository_address . $FileName . '" width="' . $FileInfoSize[0] . '" height="' . $FileInfoSize[1] . '" alt="' . $FileTitle . '" title="' . $FileTitle . '">');
            } else {

                $FileNameChSize = $this->NameChSize($repository_address, $FileName, $ChSize, 1);
                
                $FileAddressChSize = $repository_thumbnail_address . $FileNameChSize;

                
                
                if ($this->FileExist($repository_thumbnail_address, $FileNameChSize)) {
                    $FileInfoSizeChSize = parent::FindFileInfoSize($FileAddressChSize);

                    return ('<img ' . $ImgClass . ' ' . $ImageSrc . '="' . $FileAddressChSize . '" width="' . $FileInfoSizeChSize[0] . '" height="' . $FileInfoSizeChSize[1] . '" alt="' . $FileTitle . '" title="' . $FileTitle . '">');
                } else {
                    

                    parent::ImageOptAndStorage($repository_address . $FileName, $repository_thumbnail_address, $FileNameChSize, $ChSize, $hadjust);
                    

                    if ($WaterMark) {
                        parent::SetWaterMark($FileAddressChSize, $repository_thumbnail_address, $strRootStart . './itemplates/ipanel/build/icon/watermark.png', $Margin);
                    }

                    $FileInfoSizeChSize = parent::FindFileInfoSize($FileAddressChSize);

                    return ('<img ' . $ImgClass . ' ' . $ImageSrc . '="' . $FileAddressChSize . '" width="' . $FileInfoSizeChSize[0] . '" height="' . $FileInfoSizeChSize[1] . '" alt="' . $FileTitle . '" title="' . $FileTitle . '">');


                }
            }

        } else {
            return ('<img ' . $ImgClass . ' ' . $ImageSrc . '="' . $strRootStart . './itemplates/ipanel/build/icon/no-image.jpg" width="100%" height="auto" alt="no image" title="no image">');
        }
    }

    public function FileExist($repository_address, $FileName)
    {
        return (file_exists($repository_address . $FileName));
    }

    public function NameChSize($FileRoot, $FileName, $ChSize, $webp = 0)
    {

        $FileExt = parent::FindFileExt($FileRoot, $FileName);


        $FileJustName = str_replace("." . $FileExt, "", $FileName);

        $arrName = explode(".", $FileName);

        $FileJustName = $arrName[0];

        if (strpos($FileName, 'webp') !== false or $webp == 1) {

            return ($FileJustName . "--" . $ChSize . "--." . "webp");


        } else {

            return ($FileJustName . "--" . $ChSize . "--." . $FileExt);
        }

    }
}