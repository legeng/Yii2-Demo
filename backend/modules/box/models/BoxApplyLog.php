<?php

namespace backend\modules\box\models;

use Yii;
use common\models\Region;

/**
 * This is the model class for table "box_apply_log".
 *
 * @property integer $id
 * @property string $link_name
 * @property string $mobile
 * @property integer $region_id
 * @property string $address
 * @property string $open_id
 * @property string $express_no
 * @property string $create_dt
 * @property integer $status
 * @property string $remarks
 */
class BoxApplyLog extends \yii\db\ActiveRecord
{

    public $province_id;

    public $city_id;

    public static $applyStatus = [
        '1' => '申请中',
        '2' => '发货中',
        '3' => '已收货',
        '0' => '异常',
    ];

    public static $changeStatus = [
        '1' => [
            '1' => '申请中',
            '0' => '异常',
        ],
        '2' => [
            '2' => '发货中',
            '0' => '异常',
        ],
        '3' => [
            '3' => '已收货',
            '0' => '异常',
        ],
        '0' => [
            '0' => '异常',
            '1' => '申请中',
        ],
    ];

   //性别
    public static $sexType = [
        '0' => '男',
        '1' => '女',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'box_apply_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link_name', 'mobile', 'address', 'open_id', 'express_no', 'status'], 'required'],
            [['province_id','city_id','region_id', 'status' , 'box_number' , 'sex'], 'integer'],
            [['create_dt'], 'safe'],
            [['link_name', 'express_no'], 'string', 'max' => 64],
            [['mobile'], 'string', 'max' => 16],
            [['address', 'open_id'], 'string', 'max' => 256],
            [['remarks'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link_name' => '用户名称',
            'sex' => '用户性别',
            'mobile' => '用户电话',
            'region_id' => '区域名称',
            'address' => '详细地址',
            'open_id' => 'Open ID',
            'express_no' => '快递单号',
            'create_dt' => '申请时间',
            'box_number' => '数量',
            'apply_type' => '申请类型',
            'status' => '状态',
            'remarks' => '备注',
        ];
    }

    public function getRegion()
    {
        // 订单对应的区域 1 对 1
        return $this->hasOne(Region::className() , ['id' => 'region_id']);
    }
}
