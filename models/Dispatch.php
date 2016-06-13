<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dispatch".
 *
 * @property integer $dispatch_id
 * @property string $dispatch_timestamps
 * @property string $dispatch_comment
 * @property integer $repository_to_id
 * @property integer $dispatch_status
 *
 * @property Repository $repositoryTo
 * @property DispatchDetail[] $dispatchDetails
 */
class Dispatch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dispatch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dispatch_timestamps'], 'safe'],
            [['repository_to_id'], 'required'],
            [['repository_to_id', 'dispatch_status'], 'integer'],
            [['dispatch_comment'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dispatch_id' => 'Dispatch ID',
            'dispatch_timestamps' => 'Dispatch Timestamps',
            'dispatch_comment' => 'Dispatch Comment',
            'repository_to_id' => 'Repository To ID',
            'dispatch_status' => 'Dispatch Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepositoryTo()
    {
        return $this->hasOne(Repository::className(), ['repository_id' => 'repository_to_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDispatchDetails()
    {
        return $this->hasMany(DispatchDetail::className(), ['dispatch_id' => 'dispatch_id']);
    }
}
