<?php

namespace app\controllers;

/**
 * use Yii;
 * use yii\filters\AccessControl;
 * use yii\web\Controller;
 * use yii\filters\VerbFilter;
 * use app\models\LoginForm;
 * use app\models\ContactForm;
 * use app\models\EntryForm;
 */
use Yii;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\db\Query;
use app\models\LoginForm;
use app\models\Book;
use app\models\ContactForm;
use app\models\SignupForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;

class TableController extends Controller
{
    public function actionIndex()
    {
      /**
 *  $connection=Yii::app()->db;
 *        $sql="SELECT * FROM country";
 *        $cmd=$connection->createCommand($sql);
 *        $result=$cmd->query();
 */
         $cmd=Yii::$app->db->createCommand('SELECT * FROM country ORDER BY id');
         $provider=new ArrayDataProvider([
         'allModels'=>$cmd->queryAll(),
         'pagination' => [
          'pageSize' => 5,
         ],
         
            //'sort' => [
            //'attributes' => ['id'],
            //],
 
         ]);
         
          return $this->render('index', [
            'dataProvider'=>$provider,
        ]);
     
    }
}