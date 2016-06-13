<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "repository_address".
 *
 * @property integer $repository_address_id
 * @property integer $region_province_id
 * @property integer $region_city_id
 * @property integer $region_country_id
 * @property string $repository_address
 *
 * @property Repository[] $repositories
 * @property Region $regionProvince
 * @property Region $regionCity
 * @property Region $regionCountry
 */
class RepositoryAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'repository_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_province_id', 'region_city_id', 'region_country_id'], 'required'],
            [['region_province_id', 'region_city_id', 'region_country_id'], 'integer'],
            [['repository_address'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'repository_address_id' => 'Repository Address ID',
            'region_province_id' => 'Region Province ID',
            'region_city_id' => 'Region City ID',
            'region_country_id' => 'Region Country ID',
            'repository_address' => 'Repository Address',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepositories()
    {
        return $this->hasMany(Repository::className(), ['repository_address_id' => 'repository_address_id']);
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
