<?php

namespace app\components;

use georgique\yii2\jsonrpc\JsonRpcRequest as BaseJsonRpcRequest;
use yii\base\Model;


class JsonRpcRequest extends BaseJsonRpcRequest
{

    public function parseMethod($method)
    {
        if (!preg_match('/^[\d\w_\-.]+$/', $method)) {
            return false;
        }

        $parts = explode('.', $method);
        foreach ($parts as $part) {
            // There cannot be empty part in route
            if (empty($part)) {
                return false;
            }
        }

        return implode('/', $parts);
    }


}
