<?php

class ListTools extends Regularization
{
    public function TableHead(array $arrHeadNames, $toolsName): string
    {

        $strHeadTable = '<tr>';
        foreach ($arrHeadNames as $headName) {
            $strHeadTable .= '<th>' . $headName . '</th>';
        }

        if ($toolsName != null)
            $strHeadTable .= '<th>' . $toolsName . '</th>';

        $strHeadTable .= '</tr>';

        return $strHeadTable;

    }

    public function ReSortDataTable($arrBody, $arrSortTo)
    {

        $arrNewSort = array();
        foreach ($arrSortTo as $key) {
            $arrNewSort[$key] = $arrBody->$key;
        }
        return $arrNewSort;
    }

    public function MaskingCart($number, $HashBase64 = 0, $maskingCharacter = 'X')
    {
        if ($HashBase64)
            $number = parent::deBase64($number);

        return substr($number, 0, 4) . str_repeat($maskingCharacter, strlen($number) - 8) . substr($number, -4);
    }


    public function TableBody($arrBodyNames, array $arrIconTools, $breakNumber, $RefIdKey = null, $arrSortTo = null): string
    {
        if ($arrSortTo != null)
            $arrBodyNames = $this->ReSortDataTable($arrBodyNames, $arrSortTo);

        $strBodyTable = '<tr>';
        $intcount = 1;
        foreach ($arrBodyNames as $bodyName) {
            if ($intcount > $breakNumber)
                break;
            $strBodyTable .= '<td>' . $bodyName . '</td>';
            $intcount++;
        }


        if (count($arrIconTools) > 0) {
            $strBodyTable .= '<td>';
            foreach ($arrIconTools as $IconTools) {
                $strBodyTable .= $this->ButtonReflector($IconTools, $RefIdKey);
            }
            $strBodyTable .= '</td>';
        }

        $strBodyTable .= '</tr>';

        return $strBodyTable;
    }

    public function ButtonReflector($IconTools, $RefIdKey = null): string
    {
        return '<a class="btn ' . $IconTools[0] . '" href="' . $IconTools[3] . '&ref=' . $RefIdKey . '" aria-label="' . $IconTools[2] . '"> <i class="fa ' . $IconTools[1] . '" aria-hidden="true"></i> </a>';
    }

    public function ButtonReflectorIcon($IconTools): string
    {
        return '<a class="btn ' . $IconTools[0] . '" href="#" aria-label="' . $IconTools[2] . '"> <i class="fa ' . $IconTools[1] . '" aria-hidden="true"></i> </a>';
    }
}