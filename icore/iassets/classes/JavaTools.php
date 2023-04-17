<?php

class  JavaTools
{
    static function JsAlert($Alert): string
    {
        echo('<script > alert("' . $Alert . '"); </script>');
    }

    static function JsConfirm($Alert, $RootY, $RootN)
    {
        echo('<script > if(confirm("' . $Alert . '")){location.href ="' . $RootY . '"}else{location.href ="' . $RootN . '"} </script>');

    }

    static function JsTimeRefresh($RefreshTime, $RefreshPage): string
    {
        echo('<meta http-equiv="refresh" content="' . $RefreshTime . ';URL=' . $RefreshPage . '">');
        exit();
    }

    static  function  JsAlertWithRefresh($Alert, $RefreshTime, $RefreshPage)
    {
        echo('<script > alert("' . $Alert . '"); </script>');
        echo('<meta http-equiv="refresh" content="' . $RefreshTime . ';URL=' . $RefreshPage . '">');
        exit();
    }

    static function JsRefresh($RefreshPage): string
    {
        header("Location: " . $RefreshPage);
        exit();
    }
}
