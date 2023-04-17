<?php
//Translator.php

$objFileTools = new FileTools("farsi.csv");

foreach ($objFileTools->CSVFileReader() as $ListTranslatecaption) {

    if($ListTranslatecaption[0] == null)
        continue;

    echo('"'.strtolower($ListTranslatecaption[0]).'"=>"'.$ListTranslatecaption[1].'",</br>');
}

exit();
