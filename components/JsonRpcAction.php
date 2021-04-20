<?php

namespace app\components;

use georgique\yii2\jsonrpc\Action;
use georgique\yii2\jsonrpc\exceptions\InvalidRequestException;
use georgique\yii2\jsonrpc\exceptions\JsonRpcException;
use georgique\yii2\jsonrpc\responses\ErrorResponse;
use georgique\yii2\jsonrpc\responses\SuccessResponse;
use yii\helpers\ArrayHelper;

class JsonRpcAction extends Action
{

    /**
     * @inheritdoc
     */
    public function runWithParams($params)
    {
        $batchResponse = [];

        try {
            $isBatch = false;
            $batchRequestData = $this->parseJsonRpcBody(\Yii::$app->request->getRawBody());

            if (is_array($batchRequestData)) {
                $isBatch = true;
            } else {
                // For simple processing
                $batchRequestData = [$batchRequestData];
            }

            foreach ($batchRequestData as $requestData) {
                $this->preserveYiiRequest();
                try {
                    $request = new JsonRpcRequest();
                    $request->paramsPassMethod = $this->paramsPassMethod;
                    $request->parseAsArray = $this->requestParseAsArray;

                    $request->load(ArrayHelper::toArray($requestData), '');
                    if ($request->validate()) {
                        $result = $request->execute();
                        if (!is_null($request->id)) {
                            $batchResponse[] = new SuccessResponse($request, $result);
                        }
                    } else {
                        foreach ($request->getFirstErrors() as $attribute => $error) {
                            $request->$attribute = null;
                        }
                        throw new InvalidRequestException();
                    }
                }
                catch (InvalidRequestException $e) {
                    $batchResponse[] = new ErrorResponse($e, $request ?: null);
                }
                catch (JsonRpcException $e) {
                    // We do not return response to notifications
                    if ($request && !is_null($request->id)) {
                        $batchResponse[] = new ErrorResponse($e, $request ?: null);
                    }
                }

                $this->restoreYiiRequest();
            }
        } catch (JsonRpcException $e) {
            return new ErrorResponse($e);
        }

        return !$isBatch ? array_shift($batchResponse) : $batchResponse;
    }
}
