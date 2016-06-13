<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dispatch_detail".
 *
 * @property integer $dispatch_detail
 * @property integer $dispatch_id
 * @property integer $product_id
 * @property integer $product_num
 *
 * @property Dispatch $dispatch
 * @property Product $product
 */
class DispatchDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dispatch_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dispatch_id', 'product_id'], 'required'],
            [['dispatch_id', 'product_id', 'product_num'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dispatch_detail' => 'Dispatch Detail',
            'dispatch_id' => 'Dispatch ID',
            'product_id' => 'Product ID',
            'product_num' => 'Product Num',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDispatch()
    {
        return $this->hasOne(Dispatch::className(), ['dispatch_id' => 'dispatch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['product_id' => 'product_id']);
    }
}
