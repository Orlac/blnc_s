<?php

namespace app\controllers;

use Yii;
use app\models\ContactForm;
use app\models\LoginForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\Response;

class WeatherController extends Controller
{
    public function actions()
    {
        return array(
            'index' => array(
                'class' => \app\components\JsonRpcAction::class,
                'prefix' => 'weather',
            ),
        );
    }

    public function getByDate($date) {
        $searchObject = Yii::createObject(\app\models\HistorySearch::class);
        $result = $searchObject->getOne($date);
        if(!$searchObject->hasErrors()){
            return $this->serializeData($result);
        }else{
            throw new \nizsheanez\jsonRpc\Exception( $searchObject->getErrorsToString(), \nizsheanez\jsonRpc\Exception::INVALID_PARAMS);
            
        }
    }

    public function getHistory($lastDays) {
        $searchObject = Yii::createObject(\app\models\HistorySearch::class);
        $result = $searchObject->getHistory($lastDays);
        if(!$searchObject->hasErrors()){
            return $this->serializeData($result);
        }else{
            throw new \nizsheanez\jsonRpc\Exception( $searchObject->getErrorsToString(), \nizsheanez\jsonRpc\Exception::INVALID_PARAMS);
            
        }
    }
}
