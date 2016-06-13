<?php

namespace app\models;

use yii\base\Model;
use Yii;

class AddPurchaseForm extends Model
{
    public $productId;
    public $productNum;
    public $productPrice;
    public $productBatch;
    public $purchaseContactName;
    public $purchaseContactCall;
    public $purchaseBillCode;
    public $channel;
    public $supplier;

    public function rules()
    {
        return [
      [['productId', 'productNum', 'productPrice', 'productBatch', 'purchaseContactName', 'purchaseContactCall', ], 'required'],
      [[ 'channel', 'supplier', 'purchaseBillCode'], 'safe'],
    ];
    }

    public function getUser($user_id) {
        return Yii::$app->db->createCommand("SELECT * FROM 
            user WHERE user_id=:user_id")
        ->bindValue(':user_id', $user_id)->queryOne();
    }
}
