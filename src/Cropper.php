<?php

namespace softark\cropper;

use yii\base\InvalidConfigException;
use yii\bootstrap5\InputWidget;
use yii\helpers\ArrayHelper;
use yii\web\View;

/**
 * @author Ercan Bilgin <bilginnet@gmail.com>
 * @author Nobuo Kihara <softark@gmail.com>
 */
class Cropper extends InputWidget
{
    /**
     * if it is empty will be create automatically
     *
     * buttonId          = #cropper-select-button-$uniqueId
     * previewId         = #cropper-result-$uniqueId
     * modalId           = #cropper-modal-$uniqueId
     * imageId           = #cropper-image-$uniqueId
     * inputChangeUrlId  = #cropper-url-change-input-$uniqueId
     * closeButtonId     = #close-button-$uniqueId
     * cropButtonId      = #close-button-$uniqueId
     * inputId           = #cropper-input-$uniqueId
     *
     * @var string
     */
    public $uniqueId;

    /**
     * crop this image if its not empty
     *
     * @var string
     */
    public $imageUrl = null;

    /**
     * width int must be specified
     * height int must be specified
     *
     * preview false | array  // default false
     *     [
     *          url @url      // set in update action // automatically will be set after crop
     *          width int     // default 100
     *          height int    // default height by aspectRatio
     *     ]
     *
     * buttonCssClass string // default 'btn btn-primary'
     *
     * icons array
     *
     * @var $cropperOptions []
     */
    public $cropperOptions;

    /**
     * 'onClick' => 'function(event){
     *      // when click crop or close button
     *      // do something
     * }'
     * @var
     */
    public $jsOptions;

    /**
     * @var  bool | string
     */
    public $label;

    /**
     * default '{preview}{button}'
     *
     * @var string
     */
    public $template = '{preview}{button}';

    public $modalOptions;

    public function init()
    {
        parent::init();

        if (empty($this->uniqueId)) $this->uniqueId = uniqid('cropper_'); // set uniqueId if its empty

        $this->i18n();
        $this->setJsOptions();
        $this->setCropperOptions();
        $this->setInputLabel();
    }

    public function run()
    {
        parent::run();

        $this->view->registerCss('
            label[for=' . $this->options['id'] . '] {
                display: none;
            }
        ');

        return $this->render('cropper', [
            'model' => $this->model,
            'attribute' => $this->attribute,
            'name' => isset($this->name) ? $this->name : null,
            'value' => $this->value,
            'label' => $this->label,
            'uniqueId' => $this->uniqueId,
            'imageUrl' => $this->imageUrl,
            'cropperOptions' => $this->cropperOptions,
            'jsOptions' => $this->jsOptions,
            'template' => $this->template,
            'modalOptions' => $this->modalOptions,
        ]);
    }

    public function i18n()
    {
        if (!isset(\Yii::$app->get('i18n')->translations['cropper*'])) {
            \Yii::$app->get('i18n')->translations['cropper*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
            ];
        }
    }

    private function setCropperOptions()
    {
        $options = $this->cropperOptions;

        if (!isset($options['width']) || !isset($options['height'])) {
            throw new InvalidConfigException('Both "cropWidth" and "cropHeight" must be specified.');
        }

        // preview options
        if (isset($options['preview']) && $options['preview'] !== false) {
            if (!isset($options['preview']['url'])) {
                $options['preview']['url'] = null;
            } else if (empty($options['preview']['url'])) {
                $options['preview']['url'] = null;
            }
            $previewSizes = $this->getPreviewSizes($options);
            $options['preview']['width'] = $previewSizes['width'];
            $options['preview']['height'] = $previewSizes['height'];
        } else {
            $options['preview'] = false;
        }

        // button & icons options
        if (!isset($options['buttonCssClass'])) $options['buttonCssClass'] = 'btn btn-primary';
        if (!isset($options['useFontAwesome'])) $options['useFontAwesome'] = false;
        if ($options['useFontAwesome']) {
            if (!isset($options['icons']['browse'])) $options['icons']['browse'] = '<i class="fa-solid fa-folder-open"></i>';
            if (!isset($options['icons']['crop'])) $options['icons']['crop'] = '<i class="fa-solid fa-crop"></i>';
            if (!isset($options['icons']['ok'])) $options['icons']['ok'] = '<i class="fa-solid fa-check"></i>';
            if (!isset($options['icons']['cancel'])) $options['icons']['cancel'] = '<i class="fa-solid fa-xmark"></i>';
            if (!isset($options['icons']['zoom-in'])) $options['icons']['zoom-in'] = '<i class="fa-solid fa-magnifying-glass-plus"></i>';
            if (!isset($options['icons']['zoom-out'])) $options['icons']['zoom-out'] = '<i class="fa-solid fa-magnifying-glass-minus"></i>';
            if (!isset($options['icons']['rotate-left'])) $options['icons']['rotate-left'] = '<i class="fa-solid fa-arrow-rotate-left"></i>';
            if (!isset($options['icons']['rotate-right'])) $options['icons']['rotate-right'] = '<i class="fa-solid fa-arrow-rotate-right"></i>';
            if (!isset($options['icons']['flip-horizontal'])) $options['icons']['flip-horizontal'] = '<i class="fa-solid fa-arrows-h"></i>';
            if (!isset($options['icons']['flip-vertical'])) $options['icons']['flip-vertical'] = '<i class="fa-solid fa-arrows-v"></i>';
            if (!isset($options['icons']['move-left'])) $options['icons']['move-left'] = '<i class="fa-solid fa-arrow-left"></i>';
            if (!isset($options['icons']['move-right'])) $options['icons']['move-right'] = '<i class="fa-solid fa-arrow-right"></i>';
            if (!isset($options['icons']['move-up'])) $options['icons']['move-up'] = '<i class="fa-solid fa-arrow-up"></i>';
            if (!isset($options['icons']['move-down'])) $options['icons']['move-down'] = '<i class="fa-solid fa-arrow-down"></i>';
            if (!isset($options['icons']['cursor-cross-hair'])) $options['icons']['cursor-cross-hair'] = '<i class="fa-solid fa-plus"></i>';
            if (!isset($options['icons']['cursor-move'])) $options['icons']['cursor-scroll'] = '<i class="fa-solid fa-arrows-up-down-left-right"></i>';
        } else {
            if (!isset($options['icons']['browse'])) $options['icons']['browse'] = '🗁';
            if (!isset($options['icons']['crop'])) $options['icons']['crop'] = '⌗';
            if (!isset($options['icons']['ok'])) $options['icons']['ok'] = '✔';
            if (!isset($options['icons']['cancel'])) $options['icons']['cancel'] = '🗙';
            if (!isset($options['icons']['zoom-in'])) $options['icons']['zoom-in'] = '🔍+';
            if (!isset($options['icons']['zoom-out'])) $options['icons']['zoom-out'] = '🔍-';
            if (!isset($options['icons']['rotate-left'])) $options['icons']['rotate-left'] = '⭯';
            if (!isset($options['icons']['rotate-right'])) $options['icons']['rotate-right'] = '⭮';
            if (!isset($options['icons']['flip-horizontal'])) $options['icons']['flip-horizontal'] = '🡘';
            if (!isset($options['icons']['flip-vertical'])) $options['icons']['flip-vertical'] = '🡙';
            if (!isset($options['icons']['move-left'])) $options['icons']['move-left'] = '🡐';
            if (!isset($options['icons']['move-right'])) $options['icons']['move-right'] = '🡒';
            if (!isset($options['icons']['move-up'])) $options['icons']['move-up'] = '🡑';
            if (!isset($options['icons']['move-down'])) $options['icons']['move-down'] = '🡓';
            if (!isset($options['icons']['cursor-cross-hair'])) $options['icons']['cursor-cross-hair'] = '🞡';
            if (!isset($options['icons']['cursor-move'])) $options['icons']['cursor-scroll'] = '✥';
        }
        $this->cropperOptions = $options;
    }

    private function getPreviewSizes($options)
    {
        $previewWidth = 100;
        $previewHeight = 100;

        if (!isset($options['preview']['width'])) {
            $previewWidth = ($options['width'] >= 100) ? $options['width'] : $previewWidth;
        } else {
            if (is_string($options['preview']['width'])) {
                if (strstr($options['preview']['width'], '%') || strstr($options['preview']['width'], 'px')) {
                    $previewWidth = $options['preview']['width'];
                } else if ((int)$options['preview']['width'] > 0) {
                    $previewWidth = $options['preview']['width'] . 'px';
                }
            } else if (is_integer($options['preview']['width'])) {
                $previewWidth = $options['preview']['width'] . 'px';
            }
        }

        if (!isset($options['preview']['height'])) {
            $previewHeight = ($options['height'] >= 100) ? $options['height'] : $previewHeight;
        } else {
            if (is_string($options['preview']['height'])) {
                if (strstr($options['preview']['height'], '%') || strstr($options['preview']['height'], 'px')) {
                    $previewHeight = $options['preview']['height'];
                } else if ((int)$options['preview']['height'] > 0) {
                    $previewHeight = $options['preview']['height'] . 'px';
                }
            } else if (is_integer($options['preview']['height'])) {
                $previewHeight = $options['preview']['height'] . 'px';
            }
        }


        return ['width' => $previewWidth, 'height' => $previewHeight];
    }

    private function setInputLabel()
    {
        $label = $this->label;
        if ($label === null || (is_bool($label) && $label)) {
            $label = $this->model->getAttributeLabel($this->attribute);
        }

        $this->label = $label;
    }

    private function setJsOptions()
    {
        $posArray = [View::POS_END, View::POS_READY, View::POS_HEAD, View::POS_LOAD, View::POS_BEGIN];
        $jsOptions = $this->jsOptions;
        if (!isset($jsOptions['pos']) || (isset($jsOptions['pos']) && !ArrayHelper::isIn($jsOptions['pos'], $posArray))) {
            $jsOptions['pos'] = View::POS_END;
        }
        $this->jsOptions = $jsOptions;
    }
}
