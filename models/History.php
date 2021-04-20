<?php

namespace app\models;

use Yii;


class History extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%balance_history}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
        ];
    }

    public function fields()
    {
        return [
            'value',
            'balance',
            'user_id',
            'created_at',
        ];
    }



}
