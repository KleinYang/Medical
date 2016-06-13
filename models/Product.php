<?php

namespace app\models;

use Yii;
/**
 * This is the model class for table "product".
 *
 * @property integer $product_id
 * @property string $product_name
 * @property string $product_chemical_name
 * @property string $product_specification
 * @property integer $manufacturer_id
 * @property integer $product_num
 * @property integer $repository_id
 * @property integer $product_default_price
 * @property integer $price_id
 *
 * @property DispatchDetail[] $dispatchDetails
 * @property OrderDetail[] $orderDetails
 * @property Manufacturer $manufacturer
 * @property Price $price
 * @property Repository $repository
 * @property PurchaseDetail[] $purchaseDetails
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_manufacture_id', 'client_supplier_id', 'client_channel_id'], 'required'],
            [['client_manufacture_id', 'client_supplier_id', 'client_channel_id'], 'integer'],
            [['file'], 'string'],
            [['product_name', 'product_chemical_name', 'product_specification', 'purchase_price'
            , 'purchase_unit_price', 'retail_price', 'retail_unit_price', 'trade_price', 'trade_unit_price', 'product_validity'], 'string', 'max' => 45]
        ];
        // 'price_id'
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id'            => 'Product ID',
            'product_name'          => 'Product Name',
            'product_chemical_name' => 'Product Chemical Name',
            'product_specification' => 'Product Specification',
            'client_manufacture_id' => 'Manufacturer ID',
            'client_supplier_id'    => 'Supplier ID',
            'client_channel_id'     => 'Channel ID',
            'purchase_price'        => 'purchasePrice',
            'purchase_unit_price'   => 'purchaseUnitPrice',
            'retail_price'          => 'retailPrice',
            'retail_unit_price'     => 'retailUnitPrice',
            'trade_price'           => 'tradePrice',
            'trade_unit_price'      => 'tradeUnitPrice',
            'product_validity'      => 'Product Validity',
            'file'                  => 'file',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDispatchDetails()
    {
        return $this->hasMany(DispatchDetail::className(), ['product_id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetail::className(), ['product_id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManufacturer($client_manufacture_id)
    {
        return Yii::$app->db->createCommand("SELECT client_name FROM
         client WHERE client_id=:client_id")
        ->bindValue(":client_id", "$client_manufacture_id")->queryOne();
    }

    public function getClient($client_id) {
        return Yii::$app->db->createCommand("SELECT * FROM 
            client WHERE client_id=:client_id")
        ->bindValue(':client_id', $client_id)->queryOne();
    }

    public function getChannel($product_name) {
        $client_id =  Yii::$app->db->createCommand("SELECT client_channel_id FROM product 
            WHERE product_name=:product_name")->bindValue(':product_name', $product_name)->queryAll();
        foreach ($client_id as $v) {
            $client = Yii::$app->db->createCommand("SELECT * FROM 
            client WHERE client_id=:client_id")
        ->bindValue(':client_id', $v['client_channel_id'])->queryOne();
            $client_name[$client['client_id']] = $client['client_name'];
        }
        return $client_name;
    }

    public function getSupplier($product_name) {
        $client_id = Yii::$app->db->createCommand("SELECT client_supplier_id FROM product 
            WHERE product_name=:product_name")->bindValue(':product_name', $product_name)->queryAll();
        foreach ($client_id as $v) {
            $client = Yii::$app->db->createCommand("SELECT * FROM 
            client WHERE client_id=:client_id")
        ->bindValue(':client_id', $v['client_supplier_id'])->queryOne();
            $client_name[$client['client_id']] = $client['client_name'];
        }
        return $client_name;
    }

    
}
