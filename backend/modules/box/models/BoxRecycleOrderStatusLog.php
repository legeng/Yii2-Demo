<?php

namespace backend\modules\box\models;

use Yii;

/**
 * This is the model class for table "box_recycle_order_status_log".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $old_status
 * @property integer $new_status
 * @property string $alter_dt
 * @property integer $employee_id
 * @property string $remarks
 */
class BoxRecycleOrderStatusLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'box_recycle_order_status_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'old_status', 'new_status', 'employee_id'], 'required'],
            [['order_id', 'old_status', 'new_status', 'employee_id'], 'integer'],
            [['alter_dt'], 'safe'],
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
            'order_id' => '订单ID',
            'old_status' => '修改前状态',
            'new_status' => '修改后状态',
            'alter_dt' => '修改时间',
            'employee_id' => '操作人',
            'remarks' => '备注',
        ];
    }
}
