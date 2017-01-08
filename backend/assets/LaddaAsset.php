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
class LaddaAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    //全局css文件
    public $css = [
    	//Ladda Css
        'css/plugins/ladda/ladda-themeless.min.css',
        'css/plugins/sweetalert/sweetalert.css',
    ];

    //全局js文件
    public $js = [
        //Ladda JS
    	'js/plugins/ladda/spin.min.js',
    	'js/plugins/ladda/ladda.min.js',
    	'js/plugins/ladda/ladda.jquery.min.js', 
    ];
    
    //依赖文件
    public $depends = [ ];
}
