<?php

namespace app\controllers;

use Yii;
use app\models\News;
use app\models\NewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsapiController extends ActiveController
{

	    public $modelClass = 'app\models\News';    

    /**
     * @inheritdoc
     */
    public function behaviors()
    {   
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'create'=>['POST']
                ],
            ],
        'ContentNegotiator' => [
        'class' => \yii\filters\ContentNegotiator::className(),
        'only' => ['index', 'view','update','delete','create'],
        'formats' => [
            'application/json' => \yii\web\Response::FORMAT_JSON,
        ],
        ],
        ];
    }

}

