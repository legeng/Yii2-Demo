<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Login;
use common\models\User;
use yii\web\Response;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                //'backColor'=>0x000000,//背景颜色
                'maxLength' => 4, //最大显示个数
                'minLength' => 4,//最少显示个数
                /*'padding' => 5,//间距
                'height'=>40,//高度
                'width' => 130,  //宽度  
                'foreColor'=>0xffffff,     //字体颜色
                'offset'=>4,        //设置字符偏移量 有效果*/
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
    	if(!Yii::$app->user->isGuest){
            $this->redirect(Url::toRoute(['box/order/index']));
    		//return $this->render('index');
    	}

    	$model = new Login();

        return $this->renderPartial('login' , [
			'model' => $model,
		]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Login();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->renderPartial('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionPassword(){

        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = YII::$app->request;
        $model = User::findOne($request->get('id'));

        if($request->isAjax && !empty($request->getBodyParams())){
            if(!$model->validatePassword($request->getBodyParam('oldPassword'))){
                return [
                    'code' => 1,
                    'message' => '输入的原密码错误',
                    'forceClose' => 1,
                ];
            }
            $model->setPassword($request->getBodyParam('newPassword'));

            if($model->save()){
                return [
                    'code' => 0,
                    'message' => '你的密码已经修改',
                    'forceClose' => 1,
                ];
            }
        }else{
            return [
                'title' => '修改密码',
                'content' => $this->renderAjax('password',[
                    'model'=>$model
                ]),
            ];
        }
    }

}
