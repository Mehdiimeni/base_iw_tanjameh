<?php

class ShowFile extends StorageTools
{
    public function __construct($MainName)
    {
        parent::__construct($MainName);
    }

    public function ShowImage($strRootStart, $FileGrAddress, $FileName, $FileTitle, $ChSize = 0, $ImgClass = '', $ImageSrc = 'src', $WaterMark = 0, $Margin = 5, $hadjust = 0)
    {



        $FileAddress = $FileGrAddress . $FileName;
        $FileInfoSize = parent::FindFileInfoSize($FileAddress);

        if ($FileInfoSize != null) {




            if ($ChSize == 0) {
                return ('<img ' . $ImgClass . ' ' . $ImageSrc . '="' . $strRootStart . $FileAddress . '" width="' . $FileInfoSize[0] . '" height="' . $FileInfoSize[1] . '" alt="' . $FileTitle . '" title="' . $FileTitle . '">');
            } else {

                $FileNameChSize = $this->NameChSize($FileGrAddress, $FileName, $ChSize, 1);
                $FileAddressChSize = $FileGrAddress . 'thumbnail/' . $FileNameChSize;


                if ($this->FileExist($FileGrAddress . 'thumbnail/', $FileNameChSize)) {
                    $FileInfoSizeChSize = parent::FindFileInfoSize($FileAddressChSize);

                    return ('<img ' . $ImgClass . ' ' . $ImageSrc . '="' . $strRootStart . $FileAddressChSize . '" width="' . $FileInfoSizeChSize[0] . '" height="' . $FileInfoSizeChSize[1] . '" alt="' . $FileTitle . '" title="' . $FileTitle . '">');
                } else {

                    parent::ImageOptAndStorage($FileAddress, '../' . $FileGrAddress . 'thumbnail/', $FileNameChSize, $ChSize, $hadjust);

                    if ($WaterMark) {
                        parent::SetWaterMark($FileAddressChSize, '../' . $FileGrAddress . 'thumbnail/', './itemplates/ipanel/build/icon/watermark.png', $Margin);
                    }

                    $FileInfoSizeChSize = parent::FindFileInfoSize($FileAddressChSize);

                    return ('<img ' . $ImgClass . ' ' . $ImageSrc . '="' . $strRootStart . $FileAddressChSize . '" width="' . $FileInfoSizeChSize[0] . '" height="' . $FileInfoSizeChSize[1] . '" alt="' . $FileTitle . '" title="' . $FileTitle . '">');


                }
            }

        } else {
            return ('<img ' . $ImgClass . ' ' . $ImageSrc . '="./itemplates/ipanel/build/icon/no-image.jpg" width="100%" height="auto" alt="no image" title="no image">');
        }
    }

    public function FileExist($FileGrAddress, $FileName)
    {
        return (file_exists($FileGrAddress . $FileName));
    }

    public function FileAddress($FileGrAddress, $FileName)
    {

        if ($FileName == NULL)
            return ('./itemplates/ipanel/build/icon/no-image.jpg');

        if ($this->FileExist($FileGrAddress, $FileName)) {

            return ($FileGrAddress . $FileName);

        } else {

            return ('./itemplates/ipanel/build/icon/no-image.jpg');

        }
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