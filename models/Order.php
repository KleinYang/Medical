<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $order_id
 * @property integer $client_id
 * @property integer $order_status
 * @property integer $order_total_money
 * @property string $order_create_timestamps
 * @property string $order_complete_timestamps
 *
 * @property BillOrder[] $billOrders
 * @property Client $client
 * @property OrderDetail[] $orderDetails
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id'], 'required'],
            [['client_id', 'order_status', 'order_total_money'], 'integer'],
            [['order_create_timestamps', 'order_complete_timestamps', 'is_dispatch'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'is_dispatch' => 'is Dispatch',
            'client_id' => 'Client ID',
            'order_status' => 'Order Status',
            'order_total_money' => 'Order Total Money',
            'order_create_timestamps' => 'Order Create Timestamps',
            'order_complete_timestamps' => 'Order Complete Timestamps',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBillOrders()
    {
        return $this->hasMany(BillOrder::className(), ['order_id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient($client_id)
    {
        return Yii::$app->db->createCommand("SELECT client_name FROM
         client WHERE client_id=:client_id")
        ->bindValue(':client_id', $client_id)->queryOne();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetail::className(), ['order_id' => 'order_id']);
    }
}
