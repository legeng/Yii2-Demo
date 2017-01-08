<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "base_user_info".
 *
 * @property integer $id
 * @property string $ahs_user_id
 * @property string $open_id
 * @property string $user_name
 * @property string $mobile
 * @property integer $status
 * @property string $bind_dt
 * @property string $update_dt
 * @property string $remarks
 */
class UserInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_user_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ahs_user_id', 'open_id', 'status'], 'required'],
            [['status'], 'integer'],
            [['bind_dt', 'update_dt'], 'safe'],
            [['ahs_user_id'], 'string', 'max' => 128],
            [['open_id'], 'string', 'max' => 64],
            [['user_name'], 'string', 'max' => 256],
            [['mobile'], 'string', 'max' => 16],
            [['remarks'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '用户ID',
            'ahs_user_id' => '用户在爱回收的ID',
            'open_id' => '用户的openID',
            'user_name' => '用户名称',
            'mobile' => '用户电话',
            'status' => '用户状态',
            'bind_dt' => '绑定时间',
            'update_dt' => '更新时间',
            'remarks' => '备注',
        ];
    }
}
