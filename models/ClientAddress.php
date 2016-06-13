<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_address".
 *
 * @property integer $client_address_id
 * @property integer $region_province_id
 * @property integer $region_city_id
 * @property integer $region_country_id
 * @property string $client_address
 *
 * @property Client[] $clients
 * @property Region $regionProvince
 * @property Region $regionCity
 * @property Region $regionCountry
 */
class ClientAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_province_id', 'region_city_id', 'region_country_id'], 'required'],
            [['region_province_id', 'region_city_id', 'region_country_id'], 'integer'],
            [['client_address'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'client_address_id' => 'Client Address ID',
            'region_province_id' => 'Region Province ID',
            'region_city_id' => 'Region City ID',
            'region_country_id' => 'Region Country ID',
            'client_address' => 'Client Address',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasMany(Client::className(), ['client_address_id' => 'client_address_id']);
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
