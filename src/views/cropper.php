<?php
/** @var $this View */
/** @var $model \yii\db\ActiveRecord */
/** @var $name string */
/** @var $attribute string */
/** @var $value mixed */
/** @var $label mixed */
/** @var $uniqueId string */
/** @var $imageUrl string */
/** @var $cropperOptions mixed */
/** @var $jsOptions mixed */
/** @var $template string */
/** @var $modalOptions mixed */

use yii\base\InvalidConfigException;
use yii\web\View;
use yii\bootstrap5\Html;

softark\cropper\CropperAsset::register($this);

$cropWidth = $cropperOptions['width'];
$cropHeight = $cropperOptions['height'];
$aspectRatio = $cropWidth / $cropHeight;
$browseLabel = $cropperOptions['icons']['browse'] . ' ' . Yii::t('cropper', 'Browse');
if ($label !== false) $browseLabel = $cropperOptions['icons']['browse'] . ' ' . $label;

// button template
$buttonContent = Html::button($browseLabel, [
    'class' => $cropperOptions['buttonCssClass'],
    'data-bs-toggle' => 'modal',
    'data-bs-target' => '#cropper-modal-' . $uniqueId,
    'id' => 'cropper-select-button-' . $uniqueId,
]);

// preview template
$previewContent = null;
$previewOptions = $cropperOptions['preview'];
if ($cropperOptions['preview'] !== false) {
    $src = $previewOptions['url'];
    $previewWidth = $previewOptions['width'];
    $previewHeight = $previewOptions['height'];

    $previewImage = Html::img($src, ['id' => 'cropper-preview-' . $uniqueId, 'style' => "width: $previewWidth; height: $previewHeight;"]);
    $previewContent = '<div class="cropper-container clearfix mb-3">' .
        Html::tag('div', $previewImage, [
            'id' => 'cropper-result-' . $uniqueId,
            'class' => 'cropper-result',
            'style' => "width: $previewWidth; height: $previewHeight;",
            'data-buttonid' => 'cropper-select-button-' . $uniqueId,
            'onclick' => 'js: $("#cropper-select-button-' . $uniqueId . '").click()',
        ]) .
        '</div>';
} else {
    $previewContent = Html::img(null, ['class' => 'hidden', 'id' => 'cropper-preview-' . $uniqueId]);
}

// input template
if (!empty($name)) {
    $input = Html::tag('div', Html::input('text', $name, $value, [
        'id' => $uniqueId . '-input',
        'class' => 'visually-hidden',
    ]), ['id' => $uniqueId, 'class' => 'mb-3',]);
    $inputId = $uniqueId . '-input';
} else {
    $input = Html::tag('div', Html::activeTextInput($model, $attribute, [
            'value' => $value,
            'class' => 'visually-hidden',
        ]) . Html::error($model, $attribute), ['id' => $uniqueId, 'class' => 'mb-3',]);
    $inputId = Html::getInputId($model, $attribute);
}

// set template
$template = str_replace('{button}', $input . $buttonContent, $template);
$template = str_replace('{preview}', $previewContent, $template);
?>

<div class="cropper-wrapper clearfix">
    <?php
    echo $this->render('modal', [
        'unique' => $uniqueId,
        'cropperOptions' => $cropperOptions,
        'modalOptions' => $modalOptions,
        'bsVer' => $bsVer,
    ]);
    echo $template;
    echo Html::hiddenInput('url-change-input-' . $uniqueId, '', [
        'id' => 'cropper-url-change-input-' . $uniqueId,
    ]);
    ?>
</div>

<?php
if ($cropperOptions['preview'] !== false) {

    $this->registerCss('
    .cropper-result {
        margin-top: 10px; 
        border: 1px dotted #bfbfbf; 
        background-color: #f5f5f5;
        position: relative;   
        cursor: pointer;     
    }');
}
?>
<?php $this->registerCss('
    /*.cropper-result {
        margin-top: 10px; 
        border: 1px dotted #bfbfbf; 
        background-color: #f5f5f5;
        position: relative;   
        cursor: pointer;     
    }*/
    #cropper-modal-' . $uniqueId . ' img{
        max-width: 100%;
    }
    #cropper-modal-' . $uniqueId . ' .btn-file {
        position: relative;
        overflow: hidden;
    }
    #cropper-modal-' . $uniqueId . ' .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
    #cropper-modal-' . $uniqueId . ' .input-group .input-group-text {
        border-radius: 0;
        border-color: #d2d6de;
        background-color: #efefef;
        color: #555;
    }
    #cropper-modal-' . $uniqueId . ' .height-warning.has-success .input-group-text,
    #cropper-modal-' . $uniqueId . ' .width-warning.has-success .input-group-text{
        background-color: #00a65a;
        border-color: #00a65a;
        color: #fff;
    }
    #cropper-modal-' . $uniqueId . ' .height-warning.has-error .input-group-text,
    #cropper-modal-' . $uniqueId . ' .width-warning.has-error .input-group-text{
        background-color: #dd4b39;
        border-color: #dd4b39;
        color: #fff;
    }
') ?>

<?php

$this->registerJs(<<<JS
    var options_$uniqueId = {
        croppable: false,
        croppedCanvas: '',
        
        element: {
            modal: $('#cropper-modal-$uniqueId'),
            image: $('#cropper-image-$uniqueId'),
            _image: document.getElementById('cropper-image-$uniqueId'),            
            result: $('#cropper-result-$uniqueId')
        },
        
        input: {
            model: $('#$inputId'),
            crop: $('#cropper-input-$uniqueId'),
            urlChange: $('#cropper-url-change-input-$uniqueId')
        },
        
        button: {
            crop: $('#crop-button-$uniqueId')
        },
        
        data: {
            cropWidth: $cropWidth,
            cropHeight: $cropHeight,
            scaleX: 1,
            scaleY: 1,
            width: '',
            height: '',
            X: '',
            Y: ''
        },
     
        inputData: {
            width: $('#dataWidth-$uniqueId'),
            height: $('#dataHeight-$uniqueId'),
            X: $('#dataX-$uniqueId'),
            Y: $('#dataY-$uniqueId')
        }
    };
    
    var cropper_options_$uniqueId = {
        aspectRatio: $aspectRatio,
        viewMode: 2,            
        autoCropArea: 1.0,
        responsive: false,
        crop: function (e) {

            options_$uniqueId.data.width = Math.round(e.detail.width);
            options_$uniqueId.data.height = Math.round(e.detail.height);
            options_$uniqueId.data.X = e.detail.scaleX;
            options_$uniqueId.data.Y = e.detail.scaleY;                                               
            
            options_$uniqueId.inputData.width.val(Math.round(e.detail.width));
            options_$uniqueId.inputData.height.val(Math.round(e.detail.height));
            options_$uniqueId.inputData.X.val(Math.round(e.detail.x));
            options_$uniqueId.inputData.Y.val(Math.round(e.detail.y));                
            
            if (options_$uniqueId.data.width < options_$uniqueId.data.cropWidth) {
                options_$uniqueId.element.modal.find('.width-warning').removeClass('has-success').addClass('has-error');
            } else {
                options_$uniqueId.element.modal.find('.width-warning').removeClass('has-error').addClass('has-success');
            }
            
            if (options_$uniqueId.data.height < options_$uniqueId.data.cropHeight) {
                options_$uniqueId.element.modal.find('.height-warning').removeClass('has-success').addClass('has-error');                   
            } else {
                options_$uniqueId.element.modal.find('.height-warning').removeClass('has-error').addClass('has-success');                     
            }
        }, 
        
        ready: function () {
            options_$uniqueId.croppable = true;
        }
    }
    
    // input file change
    options_$uniqueId.input.crop.change(function(event) {
        // cropper reset
        options_$uniqueId.croppable = false;
        options_$uniqueId.element.image.cropper('destroy');        
        options_$uniqueId.element.modal.find('.width-warning, .height-warning').removeClass('has-success').removeClass('has-error');        
        // image loading        
        if (typeof event.target.files[0] === 'undefined') {
            options_$uniqueId.element._image.src = "";
            return;
        }               
        options_$uniqueId.element._image.src = URL.createObjectURL(event.target.files[0]);                
        // cropper start
        options_$uniqueId.element.image.cropper(cropper_options_$uniqueId);        
    });
    
    var imageUrl_$uniqueId = '$imageUrl';
    var setElement_$uniqueId = function(src) {
        options_$uniqueId.element.modal.find('div.modal-canvas').html('<img src="' + src + '" id="cropper-image-$uniqueId">');
        options_$uniqueId.element.image = $('#cropper-image-$uniqueId'); 
        options_$uniqueId.element._image = document.getElementById('cropper-image-$uniqueId');
    };    
    // if imageUrl is set    
    if (imageUrl_$uniqueId !== '') {
        setElement_$uniqueId(imageUrl_$uniqueId);        
    }
    // when set imageSrc directly from out 
    options_$uniqueId.input.urlChange.change(function(event) {        
        var _val = $(this).val();
        imageUrl_$uniqueId = _val;
        // cropper reset
        options_$uniqueId.croppable = false;
        options_$uniqueId.element.image.cropper('destroy');
        options_$uniqueId.element.modal.find('.width-warning, .height-warning').removeClass('has-success').removeClass('has-error');        
        if (!options_$uniqueId.element.modal.hasClass('in')) {
            setElement_$uniqueId(_val);
            options_$uniqueId.element.modal.modal('show'); 
        }
        
    });
    options_$uniqueId.element.modal.on('shown.bs.modal', function() {        
        if (imageUrl_$uniqueId !== '') {
            // cropper start
            options_$uniqueId.element.modal.find('div.modal-canvas img').cropper(cropper_options_$uniqueId);
            imageUrl_$uniqueId = '';
        }       
    });
    
    function setCrop$uniqueId() {        
        if (!options_$uniqueId.croppable) {
            return;
        }        
        options_$uniqueId.croppedCanvas = options_$uniqueId.element.image.cropper('getCroppedCanvas', {
            width: options_$uniqueId.data.cropWidth,
            height: options_$uniqueId.data.cropHeight
        });               
        options_$uniqueId.element.result.html('<img src="' + options_$uniqueId.croppedCanvas.toDataURL() + '" id="cropper-image-$uniqueId">');        
        options_$uniqueId.input.model.attr('type', 'text');        
        options_$uniqueId.input.model.val(options_$uniqueId.croppedCanvas.toDataURL());
    }

    options_$uniqueId.button.crop.click(function() { setCrop$uniqueId(); });

    options_$uniqueId.element.modal.find('.move-left').click(function() { 
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('move', -10, 0);
    });
    options_$uniqueId.element.modal.find('.move-right').click(function() {
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('move', 10, 0);     
    });
    options_$uniqueId.element.modal.find('.move-up').click(function() { 
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('move', 0, -10);      
    });
    options_$uniqueId.element.modal.find('.move-down').click(function() { 
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('move', 0, 10);
    });
    options_$uniqueId.element.modal.find('.zoom-in').click(function() {
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('zoom', 0.1); 
    });
    options_$uniqueId.element.modal.find('.zoom-out').click(function() {
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('zoom', -0.1);         
    });
    options_$uniqueId.element.modal.find('.rotate-left').click(function() { 
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('rotate', -15);
    });
    options_$uniqueId.element.modal.find('.rotate-right').click(function() { 
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('rotate', 15); 
    });
    options_$uniqueId.element.modal.find('.flip-horizontal').click(function() { 
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.data.scaleX = -1 * options_$uniqueId.data.scaleX;        
        options_$uniqueId.element.image.cropper('scaleX', options_$uniqueId.data.scaleX);
    });
    options_$uniqueId.element.modal.find('.flip-vertical').click(function() { 
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.data.scaleY = -1 * options_$uniqueId.data.scaleY;
        options_$uniqueId.element.image.cropper('scaleY', options_$uniqueId.data.scaleY);
    });
    $('#crop-button-$uniqueId').click(function() {
        $('#$uniqueId input').trigger('change');
    });
JS
    , View::POS_END);

// on click crop button
if (isset($jsOptions['onClick'])) :
    $onClick = $jsOptions['onClick'];
    $script = <<<JS
        $('#crop-button-$uniqueId').click($onClick);
JS;
    $this->registerJs($script, View::POS_END);
endif;
?>
