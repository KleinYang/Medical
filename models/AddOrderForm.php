<?php

namespace app\models;

use yii\base\Model;

class AddOrderForm extends Model
{
    public $productId;
    public $productNum;
    public $productPrice;
    public $productChannelCost;
    public $productProfit;
    public $totalAccounts;
    public $client;
    public $recommandClient;
    public $productBatch;
    public $purchaseBillCode;
    public $clientType;
    public $recommandClientType;
    public $clientProvince;
    public $recommandClientProvince;

    public function rules()
    {
        return [
      [['productId', 'productNum', 'recommandClientProvince', 'productPrice', 'client', 'clientProvince', 'recommandClient', 'productBatch', 'clientType', 'recommandClientType'], 'required'],
      [['productChannelCost', 'productProfit', 'totalAccounts', 'purchaseBillCode'], 'safe'],
    ];
    }
}
