<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "repository".
 *
 * @property integer $repository_id
 * @property string $repository_name
 * @property integer $repository_address_id
 * @property string $repository_contact_name
 * @property string $repository_contact_call
 *
 * @property Dispatch[] $dispatches
 * @property Dispatch[] $dispatches0
 * @property Price[] $prices
 * @property Product[] $products
 * @property RepositoryAddress $repositoryAddress
 */
class Repository extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'repository';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['repository_address_id'], 'required'],
            [['repository_address_id'], 'integer'],
            [['repository_name', 'repository_contact_name', 'repository_contact_call'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'repository_id' => 'Repository ID',
            'repository_name' => 'Repository Name',
            'repository_address_id' => 'Repository Address ID',
            'repository_contact_name' => 'Repository Contact Name',
            'repository_contact_call' => 'Repository Contact Call',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDispatches()
    {
        return $this->hasMany(Dispatch::className(), ['repository_from_id' => 'repository_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDispatches0()
    {
        return $this->hasMany(Dispatch::className(), ['repository_to_id' => 'repository_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrices()
    {
        return $this->hasMany(Price::className(), ['repository_id' => 'repository_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['repository_id' => 'repository_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepositoryAddress()
    {
        return $this->hasOne(RepositoryAddress::className(), ['repository_address_id' => 'repository_address_id']);
    }
}
