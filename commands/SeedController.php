<?php

namespace app\commands;

use yii\console\Controller;
use Yii;

class SeedController extends Controller
{

    /**
     * Тестовые данные 
     * */
    public function actionIndex()
    {

        $i = 0;
        $batch = [];
        $uid = 1;
        while($i < 1000)
        {
            $batch[] = [
                'value' => rand(-1000, 1000),
                'user_id' =>  rand(1, 10),
            ];
            $i++;
        }
        
        Yii::$app->db->createCommand()->batchInsert('{{%balance_history}}', array_keys($batch[0]), $batch)->execute();

    }
}
