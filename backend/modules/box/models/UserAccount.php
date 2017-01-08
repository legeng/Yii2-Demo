<?php

namespace backend\modules\box\models;

use Yii;

/**
 * This is the model class for table "base_user_account".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $account_no
 * @property integer $total_points
 * @property integer $used_points
 * @property integer $balance
 * @property integer $status
 * @property string $create_dt
 * @property string $update_dt
 * @property string $remarks
 */
class UserAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_user_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'total_points', 'used_points', 'balance', 'status'], 'integer'],
            [['account_no', 'total_points', 'used_points'], 'required'],
            [['create_dt', 'update_dt'], 'safe'],
            [['account_no'], 'string', 'max' => 32],
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
            'user_id' => 'User ID',
            'account_no' => 'Account No',
            'total_points' => 'Total Points',
            'used_points' => 'Used Points',
            'balance' => 'Balance',
            'status' => 'Status',
            'create_dt' => 'Create Dt',
            'update_dt' => 'Update Dt',
            'remarks' => 'Remarks',
        ];
    }
}
