<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Gen Li <1344372801@qq.com>
 * @since 2.0
 */
class SweetAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    //全局css文件
    public $css = [
    	//Sweet alert Css
       'css/plugins/sweetalert/sweetalert.css',
    ];

    //全局js文件
    public $js = [
        //Sweet alert JS
    	'js/plugins/sweetalert/sweetalert.min.js',
    ];
    
    //依赖文件
    public $depends = [ ];
}
