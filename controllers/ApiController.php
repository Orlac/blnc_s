<?php

namespace app\controllers;

use Yii;
use app\components\JsonRpcAction;
use georgique\yii2\jsonrpc\Controller;

class ApiController extends Controller
{
    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['class'] = JsonRpcAction::class;
        return $actions;
    }
}
