<?php

class Sanitize
{
    protected $FileAddress;
    protected $PlusNewName;

    public function __construct($FileAddress, $PlusNewName = "_san")
    {
        $this->FileAddress = $FileAddress;
        $this->PlusNewName = $PlusNewName;
    }

    public function FindFileRoot()
    {
        return str_replace(basename($this->FileAddress), "", $this->FileAddress);
    }

    public function FindFileBasename($Extension): string
    {
        return basename($this->FileAddress, $Extension);
    }

    public function FindFileSanitized($Extension): bool
    {
        $FileBasename = $this->FindFileBasename($Extension);
        if (file_exists($this->FindFileRoot() . $FileBasename . $this->PlusNewName . $Extension)) {
            return true;
        } else {
            return false;
        }
    }

    public function CreateFile($String, $Extension)
    {
        $FileBasename = $this->FindFileBasename($Extension);
        $fh = fopen($this->FindFileRoot() . $FileBasename . $this->PlusNewName . $Extension, 'w');
        fwrite($fh, $String);
        fclose($fh);
    }

    function Sanitize()
    {

        $buffer = file_get_contents($this->FileAddress);
        $search = array(
            '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
            '/[^\S ]+\</s',     // strip whitespaces before tags, except space
            '/(\s)+/s',         // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        );

        $replace = array(
            '>',
            '<',
            '\\1',
            ''
        );

        return preg_replace($search, $replace, $buffer);
    }

    function SanitizeOutput($Extension, $Renew = 0)
    {
        if ($Renew) {
            $this->CreateFile($this->Sanitize(), $Extension);
        } elseif (!$this->FindFileSanitized($Extension)) {
            $this->CreateFile($this->Sanitize(), $Extension);
        }


    }
}
