<?php

namespace app\modules\story\controllers;

use Yii;
use yii\httpclient\Client;

class DefaultController extends \yii\web\Controller
{
    public function actionIndex()
    {
       return $this->render('index');
    }

    public function actionGenStory()
    {
        $model = new \app\modules\story\models\Story();
        $response = "";

        if ($model->load(Yii::$app->request->post())) {
            $response = $model->getStory();
        } else {
            Yii::error('Load error');
        }

        return $this->render('gen-story', [
            'model' => $model,
            'response' => $response,
        ]);
    }
}