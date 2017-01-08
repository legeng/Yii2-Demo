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
class ToastrAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';


    public $css = [
    	'css/plugins/toastr/toastr.min.css', 
    ];

    public $js = [
        'js/plugins/toastr/toastr.min.js',
    ];
    
    public $depends = [ ];
}
