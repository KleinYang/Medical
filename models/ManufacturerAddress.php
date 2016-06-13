<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "manufacturer_address".
 *
 * @property integer $manufacturer_address_id
 * @property integer $region_province_id
 * @property integer $region_city_id
 * @property integer $region_country_id
 * @property string $manufacturer_address
 *
 * @property Manufacturer[] $manufacturers
 * @property Region $regionProvince
 * @property Region $regionCity
 * @property Region $regionCountry
 */
class ManufacturerAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'manufacturer_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_province_id', 'region_city_id', 'region_country_id'], 'required'],
            [['region_province_id', 'region_city_id', 'region_country_id'], 'integer'],
            [['manufacturer_address'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'manufacturer_address_id' => 'Manufacturer Address ID',
            'region_province_id' => 'Region Province ID',
            'region_city_id' => 'Region City ID',
            'region_country_id' => 'Region Country ID',
            'manufacturer_address' => 'Manufacturer Address',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManufacturers()
    {
        return $this->hasMany(Manufacturer::className(), ['manufacturer_address_id' => 'manufacturer_address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegionProvince()
    {
        return $this->hasOne(Region::className(), ['region_id' => 'region_province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegionCity()
    {
        return $this->hasOne(Region::className(), ['region_id' => 'region_city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegionCountry()
    {
        return $this->hasOne(Region::className(), ['region_id' => 'region_country_id']);
    }
}
