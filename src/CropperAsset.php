<?php

namespace softark\cropper;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Ercan Bilgin <bilginnet@gmail.com>
 * @author Nobuo Kihara <softark@gmail.com>
 */
class CropperAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $css = [
        'cropperjs/dist/cropper.min.css',
    ];
    public $js = [
        'cropperjs/dist/cropper.min.js',
        'jquery-cropper/dist/jquery-cropper.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (YII_DEBUG) {
            foreach ($this->js as $k => $js) {
                $this->js[$k] = str_replace('.min', '', $js);
            }
            foreach ($this->css as $k => $css) {
                $this->css[$k] = str_replace('.min', '', $css);
            }
        }

        parent::init();
    }
}
