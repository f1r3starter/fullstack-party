<?php
namespace app\filters;

use Yii;
use yii\base\ActionFilter;

class IssueFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        if (Yii::$app->session->get('githubToken')) {
            Yii::$app->params['githubToken'] = Yii::$app->session->get('githubToken');
            return parent::beforeAction($action);
        } else {
            Yii::$app->getResponse()->redirect('/')->send();
            return;
        }
    }
}