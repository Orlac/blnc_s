<?php

namespace app\controllers;

use Yii;
use app\models\HistorySearch;
use georgique\yii2\jsonrpc\exceptions\InvalidParamsException;
use georgique\yii2\jsonrpc\exceptions\ParseErrorException;
use yii\web\Controller;


class TestController extends Controller
{
    
    public function actionUserBalance($user_id)
    {
        return ['data'  => []];
        $searchObject = Yii::createObject(HistorySearch::class);
        $result = $searchObject->getUserBalance($user_id);
        if ($searchObject->hasErrors()) {
            throw new ParseErrorException();
        } elseif (!$result) {
            throw new InvalidParamsException();
        }
        return $result->balance;
    }

    public function actionHistory($limit)
    {
        
        $searchObject = Yii::createObject(HistorySearch::class);
        $result = $searchObject->search();
        if ($searchObject->hasErrors()) {
            throw new ParseErrorException();
        } else {
            print_r($result->getModels());
            return;
        }
    }
}
