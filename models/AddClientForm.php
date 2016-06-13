<?php

namespace app\models;

use yii\base\Model;

class AddClientForm extends Model
{
    public $name;
    public $alias;
    public $contact;
    public $tel;
    public $regionProvince;
    public $regionCity;
    public $regionCountry;
    public $detailAddress;
    public $type;
    public $email;
    public $bank_account;
    public $memo;
    public $bussiness_info;
    public $level;
    public $grade;

    public function rules()
    {
        return [
        [['name', 'contact', 'type', 'regionProvince', 'regionCountry', 'regionCity', 'detailAddress', 'alias', 
        'tel', 'email', 'bank_account', 'memo', 'bussiness_info', 'level', 'grade'], 'required'],
      ];
    }
}
