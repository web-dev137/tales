<?php

namespace app\modules\story\controllers;


use yii\httpclient\Client;

class DefaultController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $client = new Client();
        $status  = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('http://api:8000/generate_story')
            ->send();
        return $this->render('index',[
            'status' => $status->data,
        ]);
    }
}