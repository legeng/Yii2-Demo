<?php

namespace backend\modules\box\models;

use Yii;

/**
 * This is the model class for table "box_recycle_order_handle_log".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $handle_type
 * @property string $handle_desc
 * @property string $handle_dt
 * @property integer $employee_id
 * @property string $remarks
 */
class BoxRecycleOrderHandleLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'box_recycle_order_handle_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'handle_type', 'handle_desc'], 'required'],
            [['order_id', 'handle_type', 'employee_id'], 'integer'],
            [['handle_desc'], 'string'],
            [['handle_dt'], 'safe'],
            [['remarks'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '记录ID',
            'order_id' => '订单ID',
            'handle_type' => '操作类型',
            'handle_desc' => '操作描述',
            'handle_dt' => '操作时间',
            'employee_id' => 'Employee ID',
            'remarks' => 'Remarks',
        ];
    }
}
