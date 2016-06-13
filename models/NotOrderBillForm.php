<?php

namespace app\models;

use yii\base\Model;

class NotOrderBillForm extends Model
{
	public $orderBillCode;
	public $orderId;

	public function rules()
	{
		return [
		[['orderBillCode', 'orderId'], 'safe'], 
		];
	}
}