<?php

class ShippingTools extends DBORM
{

    public function __construct($dbConnection)
    {
        parent::__construct($dbConnection);
        $this->ProductWeight = 2;
    }

    public function FindBasketWeightPrice($Weight, $TotalPrice, $CurrencyName1, $CurrencyName2, $RollNumber = 65, $CoverPrice = 1.1)
    {
        $objWeightPrice = $this->SetPrice($Weight);
        $CurrencyIdKey1 = $this->FindCurrencyIdKey($CurrencyName1);
        $CurrencyIdKey2 = $this->FindCurrencyIdKey($CurrencyName2);
        $ValueRate = $this->CurrenciesConversion($CurrencyIdKey1, $CurrencyIdKey2);

        return $this->RollSet($objWeightPrice, $TotalPrice, $ValueRate, $RollNumber, $CoverPrice);
    }


    public function RollSet($objWeightPrice, $MainPrice, $ValueRate, $RollNumber, $CoverPrice)
    {
        if ($MainPrice >= $RollNumber) {
            return $ValueRate * ($objWeightPrice->ExtraPrice) * $CoverPrice;
        } else {
            return $ValueRate * ($objWeightPrice->NormalPrice) * $CoverPrice;
        }

    }

    public function FindCurrencyIdKey($CurrencyName)
    {
        return $this->Fetch(" Name = '$CurrencyName' ", 'IdKey', TableIWACurrencies)->IdKey;
    }

    public function CurrenciesConversion($CurrencyIdKey1, $CurrencyIdKey2)
    {
        return $this->Fetch("CurrencyIdKey1 = '$CurrencyIdKey1' and CurrencyIdKey2 = '$CurrencyIdKey2'", 'Rate', TableIWACurrenciesConversion)->Rate;
    }

    public function SetPrice($intWeight)
    {
        return $this->Fetch(" Weight = '$intWeight' ", 'NormalPrice,ExtraPrice', TableIWWebWeightPrice);
    }

    public function FindIntWeight($WeightIdKey)
    {
        return $this->Fetch(" IdKey = '$WeightIdKey'", 'Weight', TableIWWebWeightPrice)->Weight;
    }

    public function FindItemWeight($ProductItem)
    {

        if (!$this->ProductHasWeight($ProductItem->WeightIdKey))
            if (!$this->CatHasWeight($ProductItem->CatId))
                if (!$this->TypeHasWeight($ProductItem->ProductType))
                    if (!$this->GroupHasWeight($ProductItem->PGroup))
                        if (!$this->CategoryHasWeight($ProductItem->PCategory))
                            $this->MainHasWeight($ProductItem->PGender);

        return $this->ProductWeight;

    }


    public function ProductHasWeight($ProductWeightIdKey)
    {
        if ($ProductWeightIdKey != '') {
            $Weight = $this->FindIntWeight($ProductWeightIdKey);
            if (isset($Weight) and $Weight != 0)
                $this->ProductWeight = $Weight;

        } else {
            return false;
        }
    }


    public function CatHasWeight($ProductCatId)
    {
        if ($ProductCatId != '') {
            $GroupWeightIdKey = $this->Fetch(" CatId = '$ProductCatId' ", 'WeightIdKey', TableIWNewMenu4)->WeightIdKey;
            $Weight = $this->FindIntWeight($GroupWeightIdKey);
            if($Weight == '')
            {
                $GroupWeightIdKey = $this->Fetch(" CatId = '$ProductCatId' ", 'WeightIdKey', TableIWNewMenu3)->WeightIdKey;
                $Weight = $this->FindIntWeight($GroupWeightIdKey);
            }

            if (isset($Weight) and $Weight != 0)
                $this->ProductWeight = $Weight;

        } else {
            return false;
        }

    }

    public function TypeHasWeight($ProductType)
    {
        if ($ProductType != '') {
            $GroupWeightIdKey = $this->Fetch(" Name = '$ProductType' ", 'WeightIdKey', TableIWNewMenu4)->WeightIdKey;
            $Weight = $this->FindIntWeight($GroupWeightIdKey);

            if (isset($Weight) and $Weight != 0)
                $this->ProductWeight = $Weight;

        } else {
            return false;
        }

    }




    public function GroupHasWeight($ProductGroupName)
    {
        if ($ProductGroupName != '') {
            $GroupWeightIdKey = $this->Fetch(" Name LIKE '$ProductGroupName' ", 'WeightIdKey', TableIWNewMenu3)->WeightIdKey;
            $Weight = $this->FindIntWeight($GroupWeightIdKey);
            if (isset($Weight) and $Weight != 0)
                $this->ProductWeight = $Weight;

        } else {
            return false;
        }

    }


    public function CategoryHasWeight($ProductCategoryName)
    {
        if ($ProductCategoryName != '') {
            $CategoryWeightIdKey = $this->Fetch(" Name LIKE '$ProductCategoryName' ", 'WeightIdKey', TableIWNewMenu2)->WeightIdKey;
            $Weight = $this->FindIntWeight($CategoryWeightIdKey);

            if (isset($Weight) and $Weight != 0)
                $this->ProductWeight = $Weight;

        } else {
            return false;
        }

    }

    public function MainHasWeight($ProductMainName)
    {
        if ($ProductMainName != '') {
            $MainWeightIdKey = $this->Fetch(" Name LIKE '$ProductMainName' ", 'WeightIdKey', TableIWNewMenu)->WeightIdKey;
            $Weight = $this->FindIntWeight($MainWeightIdKey);
            if (isset($Weight) and $Weight != 0)
                $this->ProductWeight = $Weight;

        } else {
            return false;
        }

    }


    public function SortByWeight($ListProductShip)
    {
        usort($ListProductShip, function ($a, $b) {
            return $a['ValueWeight'] <=> $b['ValueWeight'];
        });

        return $ListProductShip;
    }

    public function Sort2Pack($ListProductShip, $MaxValue = 2)
    {
        $ListProductShip = $this->SortByWeight($ListProductShip);

        $box_count = 0; // Total number of shared boxes
        $item_count = count($ListProductShip);
        $box = array();// Box   Subarray 
        for ($itemindex = 0; $itemindex < $item_count; $itemindex++) {
            $_box_index = false;
            $_box_count = count($box);
            for ($box_index = 0; $box_index < $_box_count; $box_index++) {
                if ($box[$box_index]['volume'] + $ListProductShip[$itemindex]['ValueWeight'] <= $MaxValue) {
                    $_box_index = $box_index;
                    break;
                }
            }

            if ($_box_index === false) {

                $box[$_box_count]['volume'] = $ListProductShip[$itemindex]['ValueWeight'];
                $box[$_box_count]['total'] = $ListProductShip[$itemindex]['MainPrice'];
                $box[$_box_count]['items'][] = $ListProductShip[$itemindex]['IdKey'];

                $box_count++;
            } else {

                $box[$_box_index]['volume'] += $ListProductShip[$itemindex]['ValueWeight'];
                $box[$_box_index]['total'] += $ListProductShip[$itemindex]['MainPrice'];
                $box[$_box_index]['items'][] = $ListProductShip[$itemindex]['IdKey'];
            }

        }
        return $box;
    }

    public function Shipping($ListProductShip, $CurrencyName1, $CurrencyName2, $RollNumber = 65, $CoverPrice = 1.1, $MaxValue = 2)
    {
        $TotalShippingPrice = 0;
        $arrAllBox = $this->Sort2Pack($ListProductShip, $MaxValue);

        foreach ($arrAllBox as $SetBox) {
            $TotalShippingPrice += $this->FindBasketWeightPrice($SetBox['volume'], $SetBox['total'], $CurrencyName1, $CurrencyName2, $RollNumber, $CoverPrice);
        }
        return $TotalShippingPrice;

    }


}