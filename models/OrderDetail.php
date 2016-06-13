<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_detail".
 *
 * @property integer $order_detail_id
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $product_num
 * @property integer $order_detail_total_money
 *
 * @property Order $order
 * @property Product $product
 */
class OrderDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'product_num', 'order_detail_total_money'], 'required'],
            [['order_id', 'product_id', 'product_num', 'order_detail_total_money'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_detail_id' => 'Order Detail ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'product_num' => 'Product Num',
            'order_detail_total_money' => 'Order Detail Total Money',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['order_id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct($purchase_detail_id)
    {
        $product_id = Yii::$app->db->createCommand("SELECT product_id FROM
            purchase_detail WHERE purchase_detail_id = :purchase_detail_id")
        ->bindValue(':purchase_detail_id', $purchase_detail_id)->queryOne();

        return Yii::$app->db->createCommand("SELECT * FROM
         product WHERE product_id=:product_id")
        ->bindValue(':product_id', $product_id['product_id'])->queryOne();
    }

    public function getClientByManufature($purchase_detail_id) {
        $product_id = Yii::$app->db->createCommand("SELECT product_id FROM
            purchase_detail WHERE purchase_detail_id = :purchase_detail_id")
        ->bindValue(':purchase_detail_id', $purchase_detail_id)->queryOne();

        $client =  Yii::$app->db->createCommand("SELECT client_manufacture_id FROM
         product WHERE product_id=:product_id")
        ->bindValue(':product_id', $product_id['product_id'])->queryOne();

        return Yii::$app->db->createCommand("SELECT client_name 
            FROM client WHERE client_id=:client_id")
        ->bindValue(':client_id', $client['client_manufacture_id'])->queryOne();
    }

    public function getClientByChannel($purchase_detail_id) {
        $client =  Yii::$app->db->createCommand("SELECT client_channel_id FROM
         purchase_detail WHERE purchase_detail_id=:purchase_detail_id")
        ->bindValue(':purchase_detail_id', $purchase_detail_id)->queryOne();

        return Yii::$app->db->createCommand("SELECT client_name 
            FROM client WHERE client_id=:client_id")
        ->bindValue(':client_id', $client['client_channel_id'])->queryOne();
    }

    public function getClientBySupplier($purchase_detail_id) {
        $client =  Yii::$app->db->createCommand("SELECT client_supplier_id FROM
         purchase_detail WHERE purchase_detail_id=:purchase_detail_id")
        ->bindValue(':purchase_detail_id', $purchase_detail_id)->queryOne();

        return Yii::$app->db->createCommand("SELECT client_name 
            FROM client WHERE client_id=:client_id")
        ->bindValue(':client_id', $client['client_supplier_id'])->queryOne();
    }
}
