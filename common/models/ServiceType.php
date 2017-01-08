<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "base_service_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $icon
 * @property string $description
 * @property string $remarks
 */
class ServiceType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_service_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 32],
            [['icon'], 'string', 'max' => 256],
            [['description', 'remarks'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '服务方式ID',
            'name' => '服务名称',
            'icon' => '服务图标',
            'description' => '服务描述',
            'remarks' => '备注',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\searchs\ServiceTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\searchs\ServiceTypeQuery(get_called_class());
    }
}
