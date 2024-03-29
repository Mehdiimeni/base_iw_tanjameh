<?php

class ShippingTools extends DBORM
{

    public $ProductWeight;
    public function __construct($dbConnection)
    {
        parent::__construct($dbConnection);
        $this->ProductWeight = -1;
    }

    public function FindBasketWeightPrice($Weight, $TotalPrice, $currencies_conversion_id, $RollNumber = 65, $CoverPrice = 1.1)
    {
        $objWeightPrice = $this->SetPrice($Weight);
        $ValueRate = $this->CurrenciesConversion($currencies_conversion_id);
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
        return $this->Fetch(
            "Name = '$CurrencyName'",
            'id',
            TableIWACurrencies
        )->id;
    }

    public function CurrenciesConversion($currencies_conversion_id)
    {
        return $this->Fetch(
            "id = $currencies_conversion_id",
            'Rate',
            TableIWACurrenciesConversion
        )->Rate;
    }

    public function SetPrice($intWeight)
    {

        return $this->Fetch(
            "iw_product_weight_id = " . $this->Fetch(" Weight = $intWeight", 'id', TableIWWebWeight)->id,
            'NormalPrice,ExtraPrice',
            TableIWWebWeightPrice
        );
    }

    public function FindIntWeight($iw_product_weight_id)
    {

        if ($iw_product_weight_id == '') {
            return 0;
        } else {
            return @$this->Fetch(
                "id = $iw_product_weight_id",
                'Weight',
                TableIWWebWeight
            )->Weight;
        }
    }

    public function FindItemWeight($ProductItem)
    {


        if (empty($ProductItem->iw_product_weight_id) or !$this->ProductHasWeight($ProductItem->iw_product_weight_id))
            if (empty($ProductItem->iw_api_product_type_id) or !$this->TypeHasWeight($ProductItem->iw_api_product_type_id))
                if (empty($ProductItem->CatIds) or !$this->CatHasWeight($ProductItem->CatIds))
                    if (empty($ProductItem->url_group2) or !$this->Group2HasWeight($ProductItem->url_group2))
                        if (empty($ProductItem->url_group) or !$this->GroupHasWeight($ProductItem->url_group))
                            if (empty($ProductItem->url_category) or !$this->CategoryHasWeight($ProductItem->url_category))
                                if (empty($ProductItem->url_gender) or !$this->MainHasWeight($ProductItem->url_gender))
                                    $this->ProductWeight = 2;

        return $this->ProductWeight;

    }


    public function ProductHasWeight($ProductWeightIdKey)
    {



        if ($ProductWeightIdKey != '' and $ProductWeightIdKey > 0) {
            $Weight = $this->FindIntWeight($ProductWeightIdKey);

            if (isset($Weight) and $Weight > 0) {

                $this->ProductWeight = $Weight;
                return true;

            } else {
                return false;
            }


        } else {
            return false;
        }
    }


    public function CatHasWeight($ProductCatId)
    {


        $arr_cat_id = explode(',', $ProductCatId);
        $main_cat_id = $arr_cat_id[0];

        if ($main_cat_id != '') {
            $GroupWeightIdKey = @$this->Fetch(
                "CatId = '$main_cat_id' ",
                'iw_product_weight_id',
                TableIWNewMenu4
            )->iw_product_weight_id;

            if ($GroupWeightIdKey != null and $GroupWeightIdKey > 0) {

                $Weight = $this->FindIntWeight($GroupWeightIdKey);

                if ($Weight != '' and $Weight > 0) {
                    $GroupWeightIdKey = @$this->Fetch(
                        " CatId = $main_cat_id ",
                        'iw_product_weight_id',
                        TableIWNewMenu3
                    )->iw_product_weight_id;
                    $Weight = $this->FindIntWeight($GroupWeightIdKey);
                }

                if (isset($Weight) and $Weight > 0) {

                    $this->ProductWeight = $Weight;
                    return true;

                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function TypeHasWeight($iw_api_product_type_id)
    {

        if ($iw_api_product_type_id != '') {


            $TypeWeightIdKey = @$this->Fetch(
                "id = $iw_api_product_type_id",
                "iw_product_weight_id",
                TableIWApiProductType
            )->iw_product_weight_id;

            if ($TypeWeightIdKey != null and $TypeWeightIdKey > 0) {

                $Weight = $this->FindIntWeight($TypeWeightIdKey);
                if (isset($Weight) and $Weight > 0) {

                    $this->ProductWeight = $Weight;
                    return true;

                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }

    }



    public function Group2HasWeight($ProductGroupName)
    {


        if ($ProductGroupName != '' and $ProductGroupName > 0) {
            $Group2WeightIdKey = $this->Fetch(
                " Name = '$ProductGroupName' ",
                'iw_product_weight_id',
                TableIWNewMenu4
            )->iw_product_weight_id;


            if ($Group2WeightIdKey != '' and $Group2WeightIdKey > 0) {

                $Weight = $this->FindIntWeight($Group2WeightIdKey);

                if (isset($Weight) and $Weight > 0) {

                    $this->ProductWeight = $Weight;
                    return true;

                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }

    }




    public function GroupHasWeight($ProductGroupName)
    {

        if ($ProductGroupName != '' and $ProductGroupName > -1) {
            $GroupWeightIdKey = $this->Fetch(
                " Name = '$ProductGroupName' ",
                'iw_product_weight_id',
                TableIWNewMenu3
            )->iw_product_weight_id;

            if ($GroupWeightIdKey != null and $GroupWeightIdKey > 0) {
                $Weight = $this->FindIntWeight($GroupWeightIdKey);

                if (isset($Weight) and $Weight > 0) {

                    $this->ProductWeight = $Weight;
                    return true;

                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }

    }


    public function CategoryHasWeight($ProductCategoryName)
    {

        if ($ProductCategoryName != '' and $ProductCategoryName > -1) {
            $CategoryWeightIdKey = $this->Fetch(
                " Name = '$ProductCategoryName' ",
                'iw_product_weight_id',
                TableIWNewMenu2
            )->iw_product_weight_id;
            if ($CategoryWeightIdKey != '' and $CategoryWeightIdKey > 0) {

                $Weight = $this->FindIntWeight($CategoryWeightIdKey);

                if (isset($Weight) and $Weight > 0) {

                    $this->ProductWeight = $Weight;
                    return true;

                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function MainHasWeight($ProductMainName)
    {

        if ($ProductMainName != '' and $ProductMainName > -1) {
            $MainWeightIdKey = $this->Fetch(
                " Name = '$ProductMainName' ",
                'iw_product_weight_id',
                TableIWNewMenu
            )->iw_product_weight_id;

            if ($MainWeightIdKey != '' and $MainWeightIdKey > 0) {
                $Weight = $this->FindIntWeight($MainWeightIdKey);
                if (isset($Weight) and $Weight > 0) {

                    $this->ProductWeight = $Weight;
                    return true;

                } else {
                    return false;
                }
            } else {
                return false;
            }
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
        $box = array(); // Box   Subarray 
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