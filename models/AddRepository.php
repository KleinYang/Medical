<?php

namespace app\models;

use yii\base\Model;

/**
 *
 */
class AddRepository extends Model
{
    public $name;
    public $contactName;
    public $contactCall;
    public $regionProvince;
    public $regionCity;
    public $regionCountry;
    public $detailAddress;

    public function rules()
    {
        return [
      [['name', 'contactName', 'contactCall', 'regionProvince', 'regionCity', 'regionCountry', 'detailAddress'], 'required'],
    ];
    }
}
