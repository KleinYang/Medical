<?php

namespace app\models;

use yii\base\Model;

class AddProductForm extends Model
{
    public $name;
    public $chemical_name;
    public $manufacturer;
    public $repositories;
    public $suppliers;
    public $specification;
    public $purchasePrice;
    public $purchaseUnitPrice;
    public $retailPrice;
    public $retailUnitPrice;
    public $tradePrice;
    public $tradeUnitPrice;
    public $validity;
    public $file;

    public function rules()
    {
        return [
        [['name', 'manufacturer', 'chemical_name', 'repositories', 'suppliers',
        'specification', 'validity', 'purchasePrice', 'purchaseUnitPrice', 'retailPrice', 'retailUnitPrice'
        , 'tradePrice', 'tradeUnitPrice', ], 'required'],
        [['file'],'file'],
      ];
    }
}