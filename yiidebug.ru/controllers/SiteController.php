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
 * use app\models\SignupForm;
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


class SiteController extends Controller
{
    
    public function actionSay($message = 'Привет')
    {
        return $this->render('say', ['message' => $message]);
    }
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
    
    //Действие создает объект EntryForm
    public function actionEntry()
    {
        $model = new EntryForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // данные в $model удачно проверены

            // делаем что-то полезное с $model ...

            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            // либо страница отображается первый раз, либо есть ошибка в данных
            return $this->render('entry', ['model' => $model]);
        }
    }
    
    
     public function actionSignup()
    {
      /**
 *   $model = new SignupForm();
 *         if ($model->load(Yii::$app->request->post())) {
 *             if ($user = $model->signup()) {
 *                 if (Yii::$app->getUser()->login($user)) {
 *                     return $this->goHome();
 *                 }
 *             }
 *         }

 *         return $this->render('signup', [
 *             'model' => $model,
 *         ]);
 */
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();
       if ($model->load(Yii::$app->request->post())) {
              if ($user = $model->signup()) {
                  if (Yii::$app->getUser()->login($user)) {
                      return $this->goHome();
                  }
              }
          }
 
        return $this->render('signup', [
            'model' => $model,
        ]);
        
        
        
        
    }
    
     public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    
    public function actionTest()
    {   
        if ( ($val = Yii::$app->cache->get("test")) === false )
        {
            $val = $this->ComputeVerySlowNumber();
            Yii::$app->cache->set("test", $val);
        }
        
        return $this->render('test', [
            'slownumber' => $val,
        ]);
    }
    
    private function ComputeVerySlowNumber()
    {
        sleep(4);
        return rand(0,10);
    }
    
}
