<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "base_region".
 *
 * @property integer $id
 * @property integer $pid
 * @property string $name
 * @property string $service_type
 * @property integer $level
 * @property integer $open_flag
 * @property string $path
 * @property integer $short
 * @property string $remarks
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'name'], 'required'],
            [['pid', 'level', 'open_flag', 'short'], 'integer'],
            [['name'], 'string', 'max' => 256],
            [['service_type', 'path'], 'string', 'max' => 128],
            [['remarks'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '区域ID',
            'pid' => '父级区域',
            'name' => '区域名称',
            'service_type' => '服务方式',
            'level' => '区域级别',
            'open_flag' => '是否开启',
            'path' => '数据路径',
            'short' => '区域排序',
            'remarks' => '备注',
        ];
    }

    public static function getParents($id)
    {
        $query = new Query;
        $query->select(['a.id id','concat(ifnull(c.name,"")," ",ifnull(b.name,"")," ",a.name) as text'])
            ->leftJoin('base_region b' ,'a.pid=b.id')
            ->leftJoin('base_region c' ,'b.pid=c.id')
            ->from('base_region a')
            ->where(['a.id' => $id])
            ->limit(1);
        $command = $query->createCommand();
        $data = $command->queryAll();
        return $data[0]['text'];
    }
}
