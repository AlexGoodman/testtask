<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 24.05.2015
 * Time: 20:27
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Phone extends ActiveRecord{

    public $phone;
    public $vcode;

    public function rules()
    {
        return [
            [['phone', 'vcode'], 'required'],
            ['phone', 'match', 'pattern' => '/\+38\(0\d{2,2}\)\d{7,7}/']
        ];
    }
}