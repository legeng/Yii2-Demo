<?php

namespace restful\models;

use Yii;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%city_store}}".
 *
 * @property integer $id
 * @property integer $province_id
 * @property integer $city_id
 * @property integer $region_id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $flag
 * @property string $longitude
 * @property string $latitude
 * @property integer $sort
 * @property string $manager_mobile
 */
class CityStore extends \yii\db\ActiveRecord implements Linkable
{
    public $profile = '这是额外的字段';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%city_store}}';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'scenario1' => ['id', 'name', 'address'],
            'scenario2' => ['id', 'name', 'address' , 'manager_mobile'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['province_id', 'name', 'address', 'flag'], 'required'],
            [['province_id', 'city_id', 'region_id', 'sort'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['address'], 'string', 'max' => 256],
            [['phone', 'flag', 'manager_mobile'], 'string', 'max' => 32],
            [['longitude', 'latitude'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'province_id' => '省ID',
            'city_id' => '城市ID',
            'region_id' => '县ID',
            'name' => '门店名称',
            'address' => '门店地址',
            'phone' => '联系电话',
            'flag' => '是否开通维修业务',
            'longitude' => '经度',
            'latitude' => '纬度',
            'sort' => '排序',
            'manager_mobile' => '店长手机号',
        ];
    }
    //返回字段
    public function fields(){
        return ['id' , 'name'];
    }
    public function extraFields(){
        return [
            'extra'=>'profile' , //extra 返回的字段，profile是当前model对象的属性
        ];
    }
    //返回数据中添加一个链接
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['user/view', 'id' => $this->id], true),
        ];
    }
}
