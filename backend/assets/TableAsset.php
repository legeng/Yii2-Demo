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
class TableAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';


    public $css = [
    	'css/plugins/bootstrap-table/bootstrap-table.css',
    	'css/plugins/bootstrap-table/bootstrap-editable.css',
    ];

    public $js = [
        'js/plugins/bootstrap-table/bootstrap-table.js',
        'js/plugins/bootstrap-table/bootstrap-table-export.js',
        'js/plugins/bootstrap-table/tableExport.js',
        'js/plugins/bootstrap-table/bootstrap-table-editable.js',
        'js/plugins/bootstrap-table/bootstrap-editable.js',
    ];
    
    public $depends = [
        'app\assets\AppAsset',
    ];
}
