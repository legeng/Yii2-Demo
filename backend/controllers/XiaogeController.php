<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Login;
use common\models\User;
use yii\web\Response;
use yii\base\ErrorException;
use backend\modules\box\models\BoxRecycleOrder;
use backend\modules\box\models\UserAccount;
use backend\modules\box\models\UserAccountDetail;
use common\models\UserInfo;


/**
 * Xiaoge controller
 */
class XiaogeController extends Controller
{

    public $layout=false;
    public $enableCsrfValidation = false;

    public function  actionAssignOrder()
    {
        $user = User::findOne([
            'id' => Yii::$app->request->get('user_id'),
            'access_token' => Yii::$app->request->get('access_token'),
        ]);

        if(!empty($user)){
            $orderList = BoxRecycleOrder::find()
                ->where([
                    'engineer_id' => $user->id,
                    'status' => '2'
                ])
                ->all();

            return $this->render('assignOrder' , [
                'orderList' => $orderList,
            ]);
        }
        
    }


    public function actionRecycleOrder()
    {

        $user = User::findOne([
            'id' => Yii::$app->request->get('user_id'),
            'access_token' => Yii::$app->request->get('access_token'),
        ]);

        if(!empty($user)){
            $orderList = BoxRecycleOrder::find()
                ->where([
                    'engineer_id' => $user->id,
                    'status' => '3',
                ])
                ->all();

            return $this->render('recycleOrder' , [
                'orderList' => $orderList,
            ]);
        }
    }

    public function actionConfirmOrder()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;

        if($request->isAjax && !empty($request->getBodyParams())){

            $user = User::findOne([
                'id' => $request->getBodyParam('user_id'),
                'access_token' => $request->getBodyParam('access_token'),
            ]);

            if(!empty($user) && Yii::$app->user->login($user)){
                $order = BoxRecycleOrder::findOne($request->getBodyParam('id'));
                if(!empty($order)){

                    $transaction = Yii::$app->db->beginTransaction();

                    try {
                        $order->status = $request->getBodyParam('status');

                        if($order->status == 3){
                            $order->confirm_dt = date('Y-m-d H:i:s');
                        }elseif($order->status == 7){
                            $order->finish_dt = date('Y-m-d H:i:s');
                        }

                        if(!$order->save()){
                            throw new ErrorException("设置订单状态异常");
                        }

                        $user = UserAccount::findOne($order->user_id);

                        if(empty($user)){
                            throw new ErrorException("不存在此用户");
                        }
                        if(!empty($request->getBodyParam('coins'))){

                            $oldAttributes = $user->oldAttributes;

                            if(!$user->updateCounters(['balance'=>$request->getBodyParam('coins')])){
                                throw new ErrorException("用户充回收币异常");
                            }

                            $userDeal = new UserAccountDetail;
                            $userDeal->account_id = $user->id;
                            $userDeal->trade_no = date('YmdHis').mt_rand(100000,999999);
                            $userDeal->before_balance = $oldAttributes['balance'];
                            $userDeal->after_balance = $user->balance;
                            $userDeal->alter_amount = $request->getBodyParam('coins');
                            $userDeal->operate_type = 21;

                            if(!$userDeal->save()){
                                throw new ErrorException("交易流水插入异常");
                            }

                            $userInfo = UserInfo::findOne($order->user_id);
                            $postData = [
                                'openId'=> 'o_fazwsmIXn7Yy13zbi8pPe_KIwE',//$userInfo->open_id,
                                'url'=> 'http://www.baidu.com',
                                'templateId'=> 'E3HIhGX9T2NR51e3Fslu4Qyg3TsPFYCyoPROjS9Er5E',
                                'message' => [
                                    'first'=> '亲爱的'.$userInfo->user_name.'，您的积分账户有新的变动，具体内容如下：',
                                    'keyword1'=> date('Y年m月d日 H:i'),
                                    'keyword2'=> $request->getBodyParam('coins'),
                                    'keyword3'=> '完成交易',
                                    'keyword4'=> $user->balance,
                                    'remark'=> '感谢您的使用'
                                ]
                            ];

                            $response = json_decode($this->httpCurl('http://www.angellg.com/api/wx/sendWxMsg',$postData));
                            if($response->code != 0){
                                throw new ErrorException('给用户推送模板消息异常');
                            }
                        }


                        $transaction->commit();

                        return [
                            'code' => 0,
                            'message' => '操作成功',
                        ];

                    } catch (ErrorException $e) {

                        Yii::error($e->getMessage());
                        $transaction->rollBack();

                        return [
                            'code' => 1,
                            'message' => $e->getMessage(),
                        ];
                    }
                }
            }else{
                return [
                    'code'=>1,
                    'message' => '操作用户不存在'
                ];
            }
        } 
    }

    public function httpCurl($url, $param=array())
    {
        $data = 'data='.urlencode(json_encode($param));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15); //超时
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
