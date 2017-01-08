<?php

namespace backend\modules\box\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\Region;

/**
 * This is the model class for table "box_recycle_order".
 *
 * @property integer $id
 * @property string $order_no
 * @property integer $user_id
 * @property integer $region_id
 * @property string $link_name
 * @property string $mobile
 * @property integer $sex
 * @property string $address
 * @property integer $service_type
 * @property integer $price
 * @property integer $reward_price
 * @property integer $status
 * @property string $expect_start_dt
 * @property string $expect_end_dt
 * @property integer $source
 * @property string $create_dt
 * @property string $update_dt
 * @property string $remarks
 */
class BoxRecycleOrder extends \yii\db\ActiveRecord
{

    public $province_id ;

    public $city_id;

    public $county_id;


    //订单状态
    public static $orderStatus = [
        '1' => '申请中',
        '2' => '已分配',
        '3' => '上门中', 
        '4' => '已收货',
        '5' => '已交货', 
        '6' => '处理中', 
        '7' => '已完成', 
        '8' => '已取消',
        '-1' => '异常'
    ];
    //订单状态
    public static $changeStatus = [
        '1' => ['1' => '申请中'],
        '2' => ['2' => '已分配'],
        '3' => ['3' => '上门中'], 
        '4' => ['4' => '已收货'],
        '5' => ['5' => '已交货'],
        '6' => ['6' => '处理中'], 
        '7' => ['7' => '已完成'], 
        '8' => ['8' => '已取消'],
    ];
    public static $handleType = [

    ];
    //性别
    public static $sexType = [
        '0' => '男',
        '1' => '女',
    ];
    //服务方式
    public static $serviceType = [
        '0' => '上门',
        '1' => '邮寄',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'box_recycle_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_no', 'engineer_id' ,'user_id', 'region_id', 'address', 'service_type', 'status'], 'required'],
            [['user_id', 'engineer_id' ,'province_id','city_id','county_id','region_id', 'sex', 'service_type', 'price', 'reward_price', 'status', 'source' , 'exception'], 'integer'],
            [['expect_start_dt', 'expect_end_dt', 'confirm_dt' ,'finish_dt','create_dt', 'update_dt'], 'safe'],
            [['order_no', 'link_name'], 'string', 'max' => 64],
            [['mobile'], 'string', 'max' => 16],
            [['address'], 'string', 'max' => 256],
            [['remarks'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '订单ID',
            'order_no' => '订单号',
            'engineer_id' => '上门人员', //对上门人员id
            'user_id' => '用户ID', //对应用户id
            'province_id' => '省份ID',
            'city_id' => '市/区ID',
            'region_id' => '区域名称', //对应区域id
            'link_name' => '用户姓名',
            'mobile' => '用户手机',
            'sex' => '用户性别',
            'address' => '用户地址',
            'service_type' => '服务方式',
            'price' => '订单金额',
            'reward_price' => '优惠金额',
            'status' => '订单状态',
            'exception' => '设置为异常订单',
            'expect_start_dt' => '预约开始时间',
            'expect_end_dt' => '预约结束时间',
            'confirm_dt' =>'确认时间',
            'finish_dt' => '完成时间',
            'source' => '订单来源',
            'create_dt' => '创建时间',
            'update_dt' => '更新时间',
            'remarks' => '备注',
        ];
    }

    public static function getOrderStatus()
    {
        return self::$orderStatus;
    }

    public function getAssignUser()
    {
        // 上们工程师和订单通过 User.id -> user_id 关联建立一对多关系
        return $this->hasOne(User::className(), ['id' => 'engineer_id']);
    }

    public function getRegion()
    {
        // 订单对应的区域 1 对 1
        return $this->hasOne(Region::className() , ['id' => 'region_id']);
    }

    public function afterSave($insert , $changedAttributes) {

        parent::afterSave($insert , $changedAttributes);
        
        //新增修改状态记录
        if(isset($changedAttributes['status'])){

            $orderStatusLog = new BoxRecycleOrderStatusLog;
            $orderStatusLog->order_id = $this->oldPrimaryKey;
            $orderStatusLog->old_status = $changedAttributes['status'];
            $orderStatusLog->new_status = $this->status;
            $orderStatusLog->employee_id = Yii::$app->user->id;
            if($orderStatusLog->old_status !== $orderStatusLog->new_status){
                $orderStatusLog->save();
            }
        }

        //新增订单操作记录
        $orderHandleLog = new BoxRecycleOrderHandleLog;
        $orderHandleLog->order_id = $this->oldPrimaryKey;
        $orderHandleLog->handle_type = 1; //0 创建 1 修改

        $desc = [];
        $attributeLabels = $this->attributeLabels();
        foreach ($changedAttributes as $key => $value) {

            $oldValue = $changedAttributes[$key];
            $newValue = $this->$key;

            if($key == 'sex'){
                $oldValue = self::$sexType[$value];
                $newValue = self::$sexType[$this->sex];
            }
            if($key == 'status'){
                $oldValue = self::$orderStatus[$value];
                $newValue = self::$orderStatus[$this->status];
            }

            if($key == 'engineer_id'){
                $oldValue = ($user = User::findOne($value)) ? $user->username.'('.$user->phone.')' : '';
                $newValue = ($user = User::findOne($this->engineer_id)) ? $user->username.'('.$user->phone.')' : '';
            }

            if($key == 'region_id'){
                $oldValue = Region::getParents($value);
                $newValue = Region::getParents($this->region_id);
            }

            $desc[] = '(修改了订单的: '.$attributeLabels[$key].' 把 '.$oldValue.' 改为 '.$newValue.')';
        }

        $orderHandleLog->handle_desc = implode("||", $desc);
        $orderHandleLog->employee_id = Yii::$app->user->id;

        $orderHandleLog->save();

    }
}
