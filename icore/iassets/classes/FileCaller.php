<?php

class FileCaller extends MakeDirectory
{
    public function FileIncluderWithControler($fullDirAddress, $nameFolder, $name, $typeInclude = 'require')
    {
        $this->fileLocationExist($fullDirAddress, '/controller/', $nameFolder . '/', $name . '.php');
        $this->fileLocationExist($fullDirAddress, '/template/', $nameFolder . '/', $name . '.php');
        $this->fileLocationExist($fullDirAddress, '/view/', $nameFolder . '/', $name . '.php');

        if ($typeInclude == 'require') {
            require_once $fullDirAddress . '/view/' . $nameFolder . '/' . $name . '.php';
        } else {
            include_once $fullDirAddress . '/view/' . $nameFolder . '/' . $name . '.php';
        }
    }

    public function FileModifyIncluderWithControler($fullDirAddress, $nameFolder, $name, $typeModify, $typeInclude = 'require')
    {
        $this->fileLocationExist($fullDirAddress, '/controller/', $nameFolder . '/', $name . 'Modify.php');
        $this->fileLocationExist($fullDirAddress, '/template/', $nameFolder . '/', $name . 'Modify.php');
        $this->fileLocationExist($fullDirAddress, '/view/', $nameFolder . '/', $name . 'Modify.php');

        if ($typeInclude == 'require') {
            require_once $fullDirAddress . '/view/' . $nameFolder . '/' . $name . 'Modify.php';
        } else {
            include_once $fullDirAddress . '/view/' . $nameFolder . '/' . $name . 'Modify.php';
        }
    }

    public function FileLocationExist($fullDirAddress, $type, $nameFolder, $nameFile)
    {
        if (!file_exists($fullDirAddress . $type . $nameFolder)) {
            parent::MKDir($fullDirAddress . $type, $nameFolder, 0755);
        }

        if (!file_exists($fullDirAddress . $type . $nameFolder . $nameFile)) {
            $fOpen = fopen($fullDirAddress . $type . $nameFolder . $nameFile, 'x');
            fwrite($fOpen, "<?php\n");
            fwrite($fOpen, "//$type$nameFolder$nameFile\n");

            if ($type == '/template/') {
                fwrite($fOpen, "?>\n");
            }

            if ($type == '/view/') {
                fwrite($fOpen, "require_once '$fullDirAddress/controller/$nameFolder$nameFile';\n");
                fwrite($fOpen, "require_once '$fullDirAddress/template/$nameFolder$nameFile';\n");
            }

            fclose($fOpen);
        }
    }
}
