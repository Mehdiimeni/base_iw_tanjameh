<?php

class StorageTools
{

    private $MainName;

    public function __construct($MainName)
    {
        $this->MainName = $MainName;
    }

    public function ClearMake($FileGrType)
    {
        $FileGrAddress = $this->FileLocation($FileGrType);
        $arrAllFile = scandir($FileGrAddress);
        foreach ($arrAllFile as $fileName) {

            if ($fileName == '.'
                or $fileName == '..')
                continue;

            if (strpos($fileName, '--') > 0)
                unlink($FileGrAddress . $fileName);

        }
    }

    public function BestMake($FileGrType, $MinSize = 1024)
    {
        $FileGrAddress = $this->FileLocation($FileGrType);
        $arrAllFile = scandir($FileGrAddress);
        foreach ($arrAllFile as $fileName) {

            if ($fileName == '.'
                or $fileName == '..')
                continue;

            if (strpos($fileName, '--') === false && filesize($FileGrAddress . $fileName) > $MinSize * 1024)
                $this->ImageOptAndStorage($FileGrAddress . $fileName, $FileGrType, $fileName);

        }

    }

    public function SetRootStoryFile($RootStoreFile, $blnMainDomain = 1)
    {

        $this->RootStoreFile = $RootStoreFile;

        if (!file_exists($this->RootStoreFile))
            (new MakeDirectory)->MKDir($this->RootStoreFile, '', 0755);

    }

    public function SetRefreshPage($RefreshPage)
    {

        $this->RefreshPage = $RefreshPage;

    }

    public function FileAllowFormat($objAllow, $fileExn): bool
    {
        $arrAllow = (array)$objAllow;
        $arrAllow = array_values($arrAllow);

        $result = false;

        if (in_array($fileExn, $arrAllow[0]))

            $result = true;

        return $result;

    }

    public function FindFileExt($FileRoot, $FileName)
    {

        if (file_exists($FileRoot . $FileName)) {
            $fileinf = @getimagesize($FileRoot . $FileName);
            return str_replace("image/", "", strtolower($fileinf['mime']));

        } else {
            $FileName = str_replace("../", "", $FileName);
            $FileName = str_replace("./", "", $FileName);
            $FileName = basename($FileName);
            $arrName = explode(".", $FileName);
            return $arrName[1];
        }

    }

    public function FindFileFact($FileGrType)
    {

        switch (strtolower($FileGrType)) {

            case "adminprofile":

                return FileSizeEnum::SizeAdminProfile();

                break;


            case "userprofile":

                return FileSizeEnum::SizeUserProfile();

                break;


            case "logo":

                return FileSizeEnum::SizeLogo();

                break;


            case "banner":

                return FileSizeEnum::SizeBanner();

                break;

            case "slider":

                return FileSizeEnum::SizeSlider();

                break;

            case "attachedimage":

                return FileSizeEnum::SizeAttachedImage();

                break;

            case "download":

                return FileSizeEnum::SizeDownload();

                break;


            case "movie":

                return FileSizeEnum::SizeMovie();

                break;


            case "virtualreality":

                return FileSizeEnum::SizeVRFile();

                break;


            case "icon":

                return FileSizeEnum::SizeIcon();

                break;

        }

    }

    public function ChangeFileSize($FileSize, $FileUnit)
    {

        switch ($FileUnit) {

            case "kb":

                return ceil($FileSize / 1024);

                break;

            case "mg":

                return ceil(($FileSize / 1024) / 1024);

                break;

            default:

                return ceil($FileSize);

        }

    }

    public function FileSize($FileSource, $FileUnit)
    {

        switch ($FileUnit) {

            case "kb":

                return ceil(filesize($FileSource) / 1024);

                break;

            case "mg":

                return ceil((filesize($FileSource) / 1024) / 1024);

                break;

            default:

                return ceil(filesize($FileSource));

        }

    }

    public function FileAllowSize($FileGrType, $FileSource)
    {

        $FileFact = (array)$this->FindFileFact($FileGrType);
        $FileFact = array_values($FileFact);

        $FileSize = filesize($FileSource);

        if ($FileFact[0][0] < $FileSize) {

            return false;

        } else {

            return true;

        }

    }

    public function FileSetNewName($FileExt, $SeoAttach = 1, $webp = 1)
    {


        if ($webp == 1)
            $FileExt = 'webp';

        if ($SeoAttach == 1) {

            return $this->MainName . '-' . strtotime("now") . '-' . mt_rand() . '.' . $FileExt;

        } else {

            return $this->MainName . '-' . strtotime("now") . '-' . $SeoAttach . '.' . $FileExt;

        }

    }

    public function FindFileInfoSize($FileSource)
    {

        if (file_exists($FileSource)) {
            return getimagesize($FileSource);
        } else {
            return null;
        }


    }

    public function ChkExt()
    {

        if (!extension_loaded('gd') and !extension_loaded('gd2')) {

            trigger_error("GD is not loaded", E_USER_WARNING);

            return false;

        }

    }

    public function ChkAndMkDir($GrType)
    {

        if (!file_exists($this->RootStoreFile . $GrType)) {

            mkdir($this->RootStoreFile . $GrType, 0755, true);

        }

    }

    public function RmFileFromStoage($GrType, $FileName)
    {

        unlink($this->RootStoreFile . $GrType . '/' . $FileName);

    }

    public function FileLocation($FileGrType)
    {

        return $this->RootStoreFile . $FileGrType . '/';

    }

    public function FileCopyServer($FileSource, $FileGrType, $FileNewName)
    {

        $this->ChkAndMkDir($FileGrType);

        $FinalRoot = $this->FileLocation($FileGrType) . $FileNewName;

        copy($FileSource, $FinalRoot);

    }

    public function imagesharpe($image)
    {
        // Matrix
        $sharpen = array(
            array(-1, -1, -1),
            array(-1, 16, -1),
            array(-1, -1, -1),
        );

        $divisor = array_sum(array_map('array_sum', $sharpen));

        imageconvolution($image, $sharpen, $divisor, 0);
    }

    public function ImageOptAndStorage($FileSource, $FileGrType, $FileNewName, $ChSize = 0, $hadjust = 0, $sharp = 0,$Refresh = 1)
    {



        $this->ChkAndMkDir($FileGrType);

        $FileInfoSize = $this->FindFileInfoSize($FileSource);

        $FileExt = $this->FindFileExt('', $FileSource);

        if ($ChSize == 0) {

            $FileFact = (array)$this->FindFileFact($FileGrType);
            $FileFact = array_values($FileFact);
            $intFileFactW = $FileFact[0][1];


        } else {

            $intFileFactW = $ChSize;


        }


        $FinalRoot = $this->FileLocation($FileGrType) . $FileNewName;

        if($FileInfoSize[0] != 0) {
            $hadjust == 0 ? $Div = ($FileInfoSize[0] / $intFileFactW) : $Div = ($FileInfoSize[1] / $intFileFactW);

            $ImageRootW = floor($FileInfoSize[0] / $Div);

            $ImageRootH = floor($FileInfoSize[1] / $Div);

            switch ($FileExt) {
                case 'jpeg':
                case 'jpg':
                    $ImageCreate = imagecreatefromjpeg($FileSource);
                    break;

                case 'png':
                    $ImageCreate = imagecreatefrompng($FileSource);
                    imagepalettetotruecolor($ImageCreate);
                    imagealphablending($ImageCreate, true);
                    imagesavealpha($ImageCreate, true);
                    break;

                case 'gif':
                    $ImageCreate = imagecreatefromgif($FileSource);
                    break;

                case 'webp':
                    $ImageCreate = imagecreatefromwebp($FileSource);
                    break;
                default:
                    return false;
            }


            if ($sharp)
                $this->imagesharpe($ImageCreate);

            $ImageRootP = imagecreatetruecolor($ImageRootW, $ImageRootH);

            if (($FileExt == 'gif') or ($FileExt == 'png')) {

                $Black = imagecolorallocate($ImageCreate, 76, 82, 94);

                $TrnprtIndx = imagecolortransparent($ImageCreate, $Black);

                if ($TrnprtIndx >= 0) {

                    $TrnprtColor = imagecolorsforindex($ImageCreate, $TrnprtIndx);

                }

                $TrnprtIndx = imagecolorallocate($ImageRootP, $TrnprtColor['red'], $TrnprtColor['green'], $TrnprtColor['blue']);

                imagefill($ImageRootP, 0, 0, $TrnprtIndx);

                imagecolortransparent($ImageRootP, $TrnprtIndx);

                if ($FileExt == 'png') {

                    imagealphablending($ImageRootP, false);

                    $color = imagecolorallocatealpha($ImageRootP, 0, 0, 0, 127);

                    imagefill($ImageRootP, 0, 0, $color);

                    imagesavealpha($ImageRootP, true);

                }

            }


            $ImageRootP = imagecreatetruecolor($ImageRootW, $ImageRootH);


            imagecopyresampled($ImageRootP, $ImageCreate, 0, 0, 0, 0, ceil($ImageRootW), ceil($ImageRootH), $FileInfoSize[0], $FileInfoSize[1]);


            imagewebp($ImageRootP, $FinalRoot);

            imagedestroy($ImageRootP);
        }

        if ($_SERVER['HTTP_HOST'] != 'localhost' and $Refresh)
            header("Location: " . $this->RefreshPage);

    }

    public function SetWaterMark($MainFile, $FileGrType, $WaterMark, $Margin = 5, $sharp = 0, $pos = 'center')
    {


        $FinalRoot = $MainFile;


        $stamp = imagecreatefrompng($WaterMark);

        $FileExt = $this->FindFileExt('', $MainFile);


        switch ($FileExt) {
            case 'jpeg':
            case 'jpg':
                $ImageCreate = imagecreatefromjpeg($FinalRoot);
                break;

            case 'png':
                $ImageCreate = imagecreatefrompng($FinalRoot);
                imagepalettetotruecolor($ImageCreate);
                imagealphablending($ImageCreate, true);
                imagesavealpha($ImageCreate, true);
                break;

            case 'gif':
                $ImageCreate = imagecreatefromgif($FinalRoot);
                break;

            case 'webp':
                $ImageCreate = imagecreatefromwebp($FinalRoot);
                break;

            default:
                return false;
        }


        if ($sharp)
            $this->imagesharpe($ImageCreate);

        $marge_right = $Margin;

        $marge_bottom = $Margin;

        $sx = imagesx($stamp);

        $sy = imagesy($stamp);

        switch ($pos) {
            case 'center':
                imagecopy($ImageCreate, $stamp, (imagesx($ImageCreate) / 2) - (imagesx($stamp) / 2), (imagesy($ImageCreate) / 2) - (imagesy($stamp) / 2), 0, 0, imagesx($stamp), imagesy($stamp));
                break;
            default:
                imagecopy($ImageCreate, $stamp, imagesx($ImageCreate) - $sx - $marge_right, imagesy($ImageCreate) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
        }

        imagewebp($ImageCreate, $FinalRoot);

        imagedestroy($ImageCreate);

        if ($_SERVER['HTTP_HOST'] != 'localhost')
            header("Location: " . $this->RefreshPage);

    }
}

