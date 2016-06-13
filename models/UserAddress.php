<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_address".
 *
 * @property integer $user_address_id
 * @property integer $region_province_id
 * @property integer $region_city_id
 * @property integer $region_country_id
 * @property string $user_address
 *
 * @property User[] $users
 * @property Region $regionProvince
 * @property Region $regionCity
 * @property Region $regionCountry
 */
class UserAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_province_id', 'region_city_id', 'region_country_id'], 'required'],
            [['region_province_id', 'region_city_id', 'region_country_id'], 'integer'],
            [['user_address'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_address_id' => 'User Address ID',
            'region_province_id' => 'Region Province ID',
            'region_city_id' => 'Region City ID',
            'region_country_id' => 'Region Country ID',
            'user_address' => 'User Address',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['user_address_id' => 'user_address_id']);
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
