<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/skins/font-awesome.min.css',
        'css/skins/ionicons.min.css',
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
        'css/animate.css',
        'css/style.css',
    ];
    public $js = [
        'js/plugins/slimScroll/jquery.slimscroll.min.js',
        'js/plugins/fastclick/fastclick.js',
        'js/app.min.js',
        'js/config.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
