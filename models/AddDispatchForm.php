<?php

namespace app\models;

use yii\base\Model;

class AddDispatchForm extends Model
{
   	public $productId;
    public $productNum;
    public $productPrice;
    public $productChannelCost;
    public $productProfit;
    public $totalAccounts;
    public $client;
    public $productBatch;
    public $purchaseBillCode;
    public $clientType;
    public $clientProvince;

    public function rules()
    {
        return [
      [['productId', 'productNum', 'productPrice', 'client', 'clientProvince', 'productBatch', 'clientType'], 'required'],
      [['productChannelCost', 'productProfit', 'totalAccounts', 'purchaseBillCode'], 'safe'],
    ];
    }
}
