<?php
class CodeCacher
{
    private $cacheDirectory = 'cache/';

    public function cacheCode($codeKey, $codeContent)
    {

        if (!file_exists($this->cacheDirectory)) {
            mkdir($this->cacheDirectory, 0777, true);
        }

        $cacheFile = $this->cacheDirectory . $codeKey . '.php';
        file_put_contents($cacheFile, $codeContent);
    }

    public function getCachedCode($codeKey)
    {
        $cacheFile = $this->cacheDirectory . $codeKey . '.php';
        if (file_exists($cacheFile)) {



            $fileCreationTime = filectime($cacheFile);

            $currentTime = time();

            $timeDifferenceMinutes = ($currentTime - $fileCreationTime) / 60;
            if ($timeDifferenceMinutes > 1) {
                unlink($cacheFile);
                return false;
            } else {
                return file_get_contents($cacheFile);
            }
        }

        return false;
    }
}

?>