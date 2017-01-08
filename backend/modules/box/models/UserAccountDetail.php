<?php

namespace backend\modules\box\models;

use Yii;

/**
 * This is the model class for table "base_user_account_detail".
 *
 * @property integer $id
 * @property integer $account_id
 * @property string $trade_no
 * @property integer $before_balance
 * @property integer $after_balance
 * @property integer $alter_amount
 * @property integer $operate_type
 * @property string $transaction_dt
 * @property string $remarks
 */
class UserAccountDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_user_account_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'before_balance', 'after_balance', 'alter_amount', 'operate_type'], 'integer'],
            [['trade_no'], 'required'],
            [['transaction_dt'], 'safe'],
            [['trade_no'], 'string', 'max' => 128],
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
            'account_id' => 'Account ID',
            'trade_no' => 'Trade No',
            'before_balance' => 'Before Balance',
            'after_balance' => 'After Balance',
            'alter_amount' => 'Alter Amount',
            'operate_type' => 'Operate Type',
            'transaction_dt' => 'Transaction Dt',
            'remarks' => 'Remarks',
        ];
    }
}
