<?php 

namespace app\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\CaseNotes;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\filters\auth\QueryParamAuth;
use app\models\Users;
class CaseNotesController extends ActiveController
{
    public $modelClass = 'app\models\CaseNotes';    

    public function behaviors()
    {
        $behaviors = parent::behaviors();
            $behaviors['ContentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::className(),
            'only' => ['index', 'view','update','delete'],
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];
        $behaviors['verbs'] = [
                'class' => VerbFilter::className(),
                'actions' => [
                    'viewnew' => ['POST'],
                    'createnew'=>['POST'],
                    'updatenew'=>['POST'],
                    'deletenew'=>['POST'],
                    'Indexnew'=>['POST']
                   
                ],
            ];

        return $behaviors;
    }


    public function actions()
    {
        $actions = parent::actions();
         return $actions;
    }
    public function actionIndexnew()
        {
          $Authorization = Yii::$app->request->post('Authorization');
          //   $user = Users::findOne(['authKey'=>$Authorization]);
          //   $user = Users::findOne(['authKey'=>$Authorization]); 
          //   if(!empty($user)){ 
          //   $model= new CaseNotes;

          //    if($model=$this->findModel()){
          //    return array('status'=>'success','CaseNotes'=>$model);
          //   }else{
          //        return  array('status'=>'success','errors'=>$model->errors); 
          //   }
          // }
          // else{
          //      return  array('status'=>'fail','msg'=>"Unauthorized access not allowed!"); 
          // }
        $searchModel = new caseNotesSearch();
        $searchModel->created_by=Yii::$app->user->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        }

    public function actionViewnew()
        { 
           $Authorization = Yii::$app->request->post('Authorization');
            $user = Users::findOne(['authKey'=>$Authorization]);
            if(!empty($user)){ 
              $model= new CaseNotes;
              $model = CaseNotes::findOne(['id'=>Yii::$app->request->post('id')]);
              if(empty($model)){
                 return  array('status'=>'fail','msg'=>"Case note not found"); 
                }
                if($model = CaseNotes::findOne(['id'=>Yii::$app->request->post('id')])&& $model->status=="1"){
                  if($model = CaseNotes::findOne(['id'=>Yii::$app->request->post('id')])){
        
                   return array('status'=>'success','CaseNotes'=>$model);
                  }
                  else{
                       return  array('status'=>'fail','errors'=>$models->errors); 
                  }
                }
                else
                {
                   return  array('status'=>'fail','errors'=>"not found"); 
                }
            }
            else
            {
               return  array('status'=>'fail','msg'=>"Unauthorized access not allowed!"); 
            }
        } 



    public function actionCreatenew()
        {
            //$headers = Yii::$app->request->post('Authorization');
            $Authorization = Yii::$app->request->post('Authorization');
            $user = Users::findOne(['authKey'=>$Authorization]); 
           if(!empty($user)){ 
            $model = new CaseNotes();
            $model->court_name = Yii::$app->request->post('court_name');
            $model->case_number = Yii::$app->request->post('case_number');
            $model->first_party_name = Yii::$app->request->post('first_party_name');
            $model->second_party_name = Yii::$app->request->post('second_party_name');
            $model->case_stage = Yii::$app->request->post('case_stage');
            //$model->second_party_name = Yii::$app->request->post('second_party_name');
            $model->prev_date= Yii::$app->request->post('prev_date');
            $model->next_date= Yii::$app->request->post('next_date');
            $model->status="1";
            $model->created_by=$user->id;
            if ($model->save()) {
                return array('status'=>'success','CaseNotes'=>$model);
            } else {
                $model->validate();
                 return  array('status'=>'fail','errors'=>$model->errors); 
            }
          }
          else{
              return  array('status'=>'fail','msg'=>"Unauthorized access not allowed!"); 
          }
        }

    public function actionUpdatenew()
    { 

      $params = $_REQUEST;

          $Authorization = Yii::$app->request->post('Authorization');
          $user = Users::findOne(['authKey'=>$Authorization]);  

      if(!empty($user))
      {    
            $model = CaseNotes::findOne(['id'=>Yii::$app->request->post('id')]);
            $model->updated_by=$user->id;
            if(empty($model))
            {
              return  array('status'=>'fail','msg'=>"Case note not found"); 

            }

            $model->attributes=Yii::$app->request->post();
            if ($model->save()) {
              return array('status'=>'success','CaseNotes'=>$model);
            } 
            else
            {
              return  array('status'=>'fail','errors'=>$model->errors); 
            }
      }
      else
      {
            return  array('status'=>'fail','msg'=>"Unauthorized access not allowed!"); 
        
      }
    }
    public function actionDeletenew()
    { 
          $Authorization = Yii::$app->request->post('Authorization');
            $user = Users::findOne(['authKey'=>$Authorization]); 
      if(!empty($user))
      {    

            $model = CaseNotes::findOne(['id'=>Yii::$app->request->post('id')]);
            if(empty($model))
            {
              return  array('status'=>'fail','msg'=>"Case note not found"); 

            }
            $model->status="2";
            if ($model->update()) {
              return array('status'=>'success','msg'=>"record deleted successfully");
            } 
            else
            {
              return  array('status'=>'fail','msg'=>"record already deleted"); 
            }
      }
      else
      {
            return  array('status'=>'fail','msg'=>"Unauthorized access not allowed!"); 
        
      }
    }
    
}
?>