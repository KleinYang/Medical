<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "purchase_detail".
 *
 * @property integer $purchase_detail_id
 * @property integer $purchase_id
 * @property integer $product_id
 * @property integer $product_num
 * @property integer $purchase_detail_total_money
 *
 * @property Product $product
 * @property Purchase $purchase
 */
class PurchaseDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchase_id', 'product_id'], 'required'],
            [['purchase_id', 'product_id', 'product_num', 'purchase_detail_total_money'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'purchase_detail_id' => 'Purchase Detail ID',
            'purchase_id' => 'Purchase ID',
            'product_id' => 'Product ID',
            'is_dispatch' => 'Is Dispatch',
            'product_dispatch_id' => 'Product Dispatch ID',
            'product_num' => 'Product Num',
            'purchase_detail_total_money' => 'Purchase Detail Total Money',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct($product_id)
    {
        return Yii::$app->db->createCommand("SELECT * 
            FROM product WHERE product_id=:product_id")
        ->bindValue(":product_id", $product_id)->queryOne();
    }

    public function getManufacturerByProduct($product_id)
    {
        $client_manufacture_id = Yii::$app->db->createCommand("SELECT client_manufacture_id 
            FROM product WHERE product_id=:product_id")
        ->bindValue(":product_id", $product_id)->queryOne();

        return Yii::$app->db->createCommand("SELECT client_name 
            FROM client WHERE client_id=:client_id")
        ->bindValue(":client_id", $client_manufacture_id['client_manufacture_id'])->queryOne();
    }

    public function getChannelByProduct($product_id)
    {
        return Yii::$app->db->createCommand("SELECT client_channel_id 
            FROM purchase_detail WHERE purchase_detail_id=:purchase_detail_id")
        ->bindValue(":purchase_detail_id", $product_id)->queryOne();

    }

    public function getSupplierByProduct($product_id)
    {
        return Yii::$app->db->createCommand("SELECT client_supplier_id 
            FROM purchase_detail WHERE purchase_detail_id=:purchase_detail_id")
        ->bindValue(":purchase_detail_id", $product_id)->queryOne();

        
    }

    public function getCleintName($client_id)
    {
        return Yii::$app->db->createCommand("SELECT client_name
            FROM client WHERE client_id=:client_id")
        ->bindValue(":client_id", $client_id)->queryOne();
    }
}
