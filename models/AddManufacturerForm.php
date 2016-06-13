<?php

namespace app\models;

use yii\base\Model;

class AddManufacturerForm extends Model
{
    public $name;
    public $regionProvince;
    public $regionCity;
    public $regionCountry;
    public $detailAddress;

    public function rules()
    {
        return [
        [['name', 'regionProvince', 'regionCountry', 'regionCity', 'detailAddress'], 'required'],
      ];
    }
}
