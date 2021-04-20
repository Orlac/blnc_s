<?php

namespace app\controllers;

use Yii;
use app\models\HistorySearch;
use georgique\yii2\jsonrpc\exceptions\InvalidParamsException;
use georgique\yii2\jsonrpc\exceptions\ParseErrorException;
use yii\rest\Controller;

class BalanceController extends Controller
{

    public $serializer = '\georgique\yii2\jsonrpc\JsonRpcSerializer';
    
    public function actionUserBalance($user_id)
    {
        $searchObject = Yii::createObject(HistorySearch::class);
        $result = $searchObject->getUserBalance($user_id);
        if ($searchObject->hasErrors()) {
            throw new ParseErrorException();
        } elseif (!$result) {
            throw new InvalidParamsException();
        }

        return $result->balance;
    }

    public function actionHistory($user_id = null, $limit = 50, $page = 0)
    {
        $searchObject = Yii::createObject(HistorySearch::class);
        $result = $searchObject->search($user_id);
        $result->pagination->pageSize = $limit;
        $result->pagination->page = max(0, $page - 1);
        if ($searchObject->hasErrors()) {
            throw new ParseErrorException();
        } else {
            return $result;
        }
    }
}
