<?php

namespace backend\modules\box\models;

use Yii;

/**
 * This is the model class for table "box_assign_recode".
 *
 * @property integer $id
 * @property integer $engineer_id
 * @property integer $order_id
 * @property integer $assgin_id
 * @property string $create_dt
 * @property string $updated_dt
 * @property integer $status
 * @property string $remarks
 */
class BoxAssignRecode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'box_assign_recode';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['engineer_id', 'order_id', 'assgin_id', 'status'], 'required'],
            [['engineer_id', 'order_id', 'assgin_id', 'status'], 'integer'],
            [['create_dt', 'updated_dt'], 'safe'],
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
            'engineer_id' => '上面人员',
            'order_id' => '订单ID',
            'assgin_id' => '派单人',
            'create_dt' => '创建时间',
            'updated_dt' => '更新时间',
            'status' => '状态',
            'remarks' => '备注',
        ];
    }
}
