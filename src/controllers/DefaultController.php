<?php
namespace huseyinyilmaz\comment\controllers;

class DefaultController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->redirect(["comment/index"]);
    }
}