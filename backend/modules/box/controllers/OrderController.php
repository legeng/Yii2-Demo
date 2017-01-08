<?php

namespace backend\modules\box\controllers;

use Yii;
use common\models\User;
use backend\modules\box\models\BoxRecycleOrder;
use backend\modules\box\models\BoxRecycleOrderStatusLog;
use backend\modules\box\models\BoxAssignRecode;
use backend\modules\box\models\searchs\BoxRecycleOrderSearch;
use backend\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use yii\base\ErrorException;

/**
 * OrderController implements the CRUD actions for BoxRecycleOrder model.
 */
class OrderController extends BaseController
{

    public function actions()
    {
        return \yii\helpers\ArrayHelper::merge(parent::actions(), [
           'editOrder' => [
               'class' => \kartik\grid\EditableColumnAction::className(),
               'modelClass' => BoxRecycleOrder::className(),
               'outputValue' => function ($model, $attribute, $key, $index) {
                     // return  $model->$attribute / 100;//;      // return any custom output value if desired
               },
               'outputMessage' => function($model, $attribute, $key, $index) {
                     return '';                      // any custom error to return after model save
               },
               'showModelErrors' => true,                        // show model validation errors after save
               // 'errorOptions' => ['header' => ''],                // error summary HTML options
               // 'postOnly' => true,
               // 'ajaxOnly' => true,
           ],

       ]);
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all BoxRecycleOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BoxRecycleOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // sleep(50);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single BoxRecycleOrder model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> '订单详情',
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('关闭',['class'=>'btn btn-default','data-dismiss'=>"modal"])
                ];
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new BoxRecycleOrder model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new BoxRecycleOrder();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new BoxRecycleOrder",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new BoxRecycleOrder",
                    'content'=>'<span class="text-success">Create BoxRecycleOrder success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                ];
            }else{
                return [
                    'title'=> "Create new BoxRecycleOrder",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

    }

    /**
     * Updates an existing BoxRecycleOrder model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update BoxRecycleOrder #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "BoxRecycleOrder #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                 return [
                    'title'=> "Update BoxRecycleOrder #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing BoxRecycleOrder model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['close'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing BoxRecycleOrder model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['close'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }

    }

    /**
     * Finds the BoxRecycleOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BoxRecycleOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BoxRecycleOrder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //单个订单分配
    public function actionSignleAssign()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        $model = BoxRecycleOrder::findOne($request->get('id'));

        if(!in_array($model->status,[1,2])){
            return [
                'code' => 1,
                'message' => '该订单状态不能进行分配',
                'close' => 1,
            ];
        }

        if($request->isAjax && !empty($request->getBodyParams())){

            $transaction = Yii::$app->db->beginTransaction();

            try
            {
                $model->load($request->post());
                $model->status = 2;//标识为已分配
                if(!$model->save()){
                    throw new ErrorException("保存订单数据异常");
                }

                BoxAssignRecode::updateAll(['status'=>0] , [
                            'order_id' => $model->id,
                        ]);

                $boxAssignRecode = BoxAssignRecode::findone([
                    'order_id' => $model->id,
                    'engineer_id' => $model->engineer_id,
                ]);

                if($boxAssignRecode){

                    $boxAssignRecode->status = 1;

                    if(!$boxAssignRecode->save()){
                        throw new ErrorException("修改分配记录数据异常");
                    }
                }else{

                    $boxAssignRecode = new BoxAssignRecode;
                    $boxAssignRecode->order_id = $model->id;
                    $boxAssignRecode->assgin_id = Yii::$app->user->id;
                    $boxAssignRecode->engineer_id = $model->engineer_id;
                    $boxAssignRecode->status = 1;
                    if(!$boxAssignRecode->save()){
                        throw new ErrorException("新增分配记录数据异常");
                    }
                }

                $transaction->commit();

                return [
                    'code' => 0,
                    'message' => '订单已经分配给上门人员',
                    'close' => 1,
                ];

            }catch (ErrorException $e){

                Yii::error("分配订单发生错误. orderID: {$model->id}");
                $transaction->rollBack();

                return [
                    'code' => 1,
                    'message' => $e->getMessage(),
                    'close' => 1,
                ];
            }

        }else{
            return [
                    'title'=> '分配订单',
                    'content'=>$this->renderAjax('signleAssgin' , [
                         'model' => $model,
                    ]),
                ];
        }
    }

    //批量订单分配
    public function actionBatchAssign()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        $orderIds = array_filter(explode(',' , $request->get('ids' , $request->post('orderIds'))));

        $post = $request->getBodyParams();

        if($request->isAjax && !empty($post)){

            $transaction = Yii::$app->db->beginTransaction();

            //随机分配
            try {

                while (count($orderIds) > 0) {
                    $orderId = array_shift($orderIds);//单个订单id

                    $model = BoxRecycleOrder::findOne($orderId);

                    if($model->status != 1){
                        throw new ErrorException('请检查选中订单的状态');
                    }

                    if(!empty($post['engineer_id'])){
                        $assginId = $post['engineer_id'];
                    }else{

                        $allAssign = ArrayHelper::getColumn(User::find()
                            ->select(['id'])
                            ->where([
                                'region_id' => $model->region_id,
                            ])
                            ->asArray()
                            ->all() , 'id'); //所有该区域下的上面人员的ID集合

                        $assginYes =  array_filter(ArrayHelper::getColumn(BoxRecycleOrder::find()
                                ->select(['id' , 'engineer_id' ,'region_id'])
                                ->where([
                                    'region_id' => $model->region_id,
                                ])
                                ->asArray()
                                ->all() , 'engineer_id')); //已分配的用户id集合,过滤空值

                        $assginNo = array_diff($allAssign , $assginYes) ;//未分配的用户id集合

                        $assginIds = array_merge($assginNo , $assginYes);//未分配在前，已分配在后，循环分配


                        if(count($assginIds) > 0){
                            $assginId = array_shift($assginIds); //单个用户id
                            array_push($assginIds, $assginId);//将分配的id放在最后，循环分配
                        }else{
                            return [
                                'code' => 1,
                                'message' => '该区域不存在上们人员',
                                'close' => 1,
                            ];
                        }
                    }

                    //开始订单分配
                    $model->engineer_id = $assginId;
                    $model->status = 2;//标识为已分配
                    if(!$model->save()){
                        throw new ErrorException("保存订单数据异常");
                    }

                    BoxAssignRecode::updateAll(['status'=>0] , [
                            'order_id' => $model->id,
                        ]);

                    $boxAssignRecode = BoxAssignRecode::findone([
                        'order_id' => $model->id,
                        'engineer_id' => $model->engineer_id,
                    ]);

                    if($boxAssignRecode){

                        $boxAssignRecode->status = 1;

                        if(!$boxAssignRecode->save()){
                            throw new ErrorException("修改分配记录数据异常");
                        }
                    }else{

                        $boxAssignRecode = new BoxAssignRecode;
                        $boxAssignRecode->order_id = $model->id;
                        $boxAssignRecode->assgin_id = Yii::$app->user->id;
                        $boxAssignRecode->engineer_id = $model->engineer_id;
                        $boxAssignRecode->status = 1;
                        if(!$boxAssignRecode->save()){
                            throw new ErrorException("新增分配记录数据异常");
                        }
                    }
                }

                $transaction->commit();

                return [
                    'code' => 0,
                    'message' => '订单已经分配给上门人员',
                    'close' => 1,
                ];

            } catch (ErrorException $e) {

                Yii::error("批量分配订单发生错误.");
                $transaction->rollBack();

                return [
                    'code' => 1,
                    'message' => $e->getMessage(),
                    'close' => 1,
                ];
            }
        }else{

            $orderList = BoxRecycleOrder::find()
                    ->select(['id' ,'link_name' , 'mobile'])
                    ->where(['id'=>$orderIds])
                    ->asArray()
                    ->all();

            return [
                    'title'=> '批量分配订单',
                    'content'=>$this->renderAjax('batchAssign' , [
                         'orderList' => $orderList,
                         'orderIds' => $request->get('ids')
                    ]),
            ];
        }
    }

    //获取分配用户
    public function actionUserList($q = null, $id = null) {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $out = [
            'results' => [
                'id' => '',
                'text' => ''
            ]
        ];
        if (!is_null($q)) {
            $query = new Query;
            $query->select(['id','username','phone','concat(username , "   " , phone) as text'])
                ->from('base_employee')
                ->orWhere(['like', 'username', $q])
                ->orWhere(['like', 'phone', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => User::find($id)->username];
        }
        return $out;
    }

    /**
     *
     */
    public function actionTest(){
        print_r(preg_match('/MicroMessenger/i' , Yii::$app->request->headers->get('User-Agent')));
    }

}
