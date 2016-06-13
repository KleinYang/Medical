<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "manufacturer".
 *
 * @property integer $manufacturer_id
 * @property string $manufacturer_name
 * @property string $manufacturer_alias
 * @property integer $manufacturer_address_id
 *
 * @property ManufacturerAddress $manufacturerAddress
 * @property Product[] $products
 */
class Manufacturer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'manufacturer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['manufacturer_address_id'], 'required'],
            [['manufacturer_address_id'], 'integer'],
            [['manufacturer_name', 'manufacturer_alias'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'manufacturer_id' => 'Manufacturer ID',
            'manufacturer_name' => 'Manufacturer Name',
            'manufacturer_alias' => 'Manufacturer Alias',
            'manufacturer_address_id' => 'Manufacturer Address ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManufacturerAddress()
    {
        return $this->hasOne(ManufacturerAddress::className(), ['manufacturer_address_id' => 'manufacturer_address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['manufacturer_id' => 'manufacturer_id']);
    }
}
