<?php

namespace app\models;

use yii\base\Model;

class NotPurchaseBillForm extends Model
{
	public $purchaseBillCode;
	public $purchaseId;

	public function rules()
	{
		return [
		[['purchaseBillCode', 'purchaseId'], 'safe'], 
		];
	}
}