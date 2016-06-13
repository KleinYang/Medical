<?php

namespace app\models;

/**
 * This is the model class for table "purchase".
 *
 * @property int $purchase_id
 * @property int $purchase_total_money
 * @property string $purchase_contact_name
 * @property string $purchase_contact_call
 * @property string $purchase_create_timestamps
 * @property string $purchase_complete_timestamps
 * @property string $purchase_status
 * @property BillPurchase[] $billPurchases
 * @property PurchaseDetail[] $purchaseDetails
 */
class Purchase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchase';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['purchase_total_money', 'purchase_status'], 'integer'],
            [['purchase_create_timestamps', 'purchase_complete_timestamps'], 'safe'],
            [['purchase_contact_name', 'purchase_contact_call'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'purchase_id' => 'Purchase ID',
            'purchase_total_money' => 'Purchase Total Money',
            'purchase_contact_name' => 'Purchase Contact Name',
            'purchase_contact_call' => 'Purchase Contact Call',
            'purchase_create_timestamps' => 'Purchase Create Timestamps',
            'purchase_complete_timestamps' => 'Purchase Complete Timestamps',
            'purchase_status' => 'Purchase Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBillPurchases()
    {
        return $this->hasMany(BillPurchase::className(), ['purchase_id' => 'purchase_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::className(), ['purchase_id' => 'purchase_id']);
    }

    
}
