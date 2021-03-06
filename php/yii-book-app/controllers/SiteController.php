<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Post;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
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

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Yii 使用 action 前缀区分普通方法和操作。 action 前缀后面的名称被映射为操作的 ID
     */
    public function actionSay($message = 'Hello') 
    {
        return $this->render('say', ['message' => $message]);
    }


    /**
     * 图书管理页面 首页
     */
    public function actionBook() 
    {
        $model = new Post;

        print($model->load(Yii::$app->request->post()));
        
        $lists = Yii::$app->db->createCommand("SELECT * FROM books_list")->queryAll();

        return $this->render('book_manage', ['lists' => $lists]);
    }

    /**
     * 图书详情
     */
     public function actionDetail($id = 0)
     {
        // 请求数据
        $list = Yii::$app->db->createCommand("SELECT * FROM books_list where id = $id")->queryOne();

        return $this->render('view_book', ['title' => $list['title'], 'desc' => $list['desc'], 'logoPath' => $list['logoPath']]);
     }

     /**
      * 添加图书
      */
      public function actionAdd()
      {
         // 请求数据
        //  $list = Yii::$app->db->createCommand("SELECT * FROM books_list where id = $id")->queryOne();
        print_r(Yii::$app->request->post());
        print_r(12);
        //  return $this->render('view_book', ['title' => $list['title'], 'desc' => $list['desc'], 'logoPath' => $list['logoPath']]);
      }
     
}
