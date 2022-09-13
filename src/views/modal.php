<?php
/** @var $unique string */
/** @var $cropperOptions [] */
/** @var $modalOptions [] */
/** @var $bsVer integer */

$modalLabel = $modalOptions['title'] ?? Yii::t('cropper', 'Image Crop Editor');

$browseLabel = $cropperOptions['icons']['browse'] . ' ' . Yii::t('cropper', 'Browse');
$cropLabel = $cropperOptions['icons']['ok'] . ' ' . Yii::t('cropper', 'OK');
$cancelLabel = $cropperOptions['icons']['cancel'] . ' ' . Yii::t('cropper', 'Cancel');

$cropWidth = $cropperOptions['width'];
$cropHeight = $cropperOptions['height'];

$modalClass = $modalOptions['modalClass'] ?? 'modal-lg';
$canvasClass = $modalOptions['canvasClass'] ?? 'col-sm-8';
$panelClass = $modalOptions['panelClass'] ?? 'col-sm-4';
$sizeDisp = $modalOptions['sizeDisp'] ?? true;
$posDisp = $modalOptions['posDisp'] ?? true;
$sizeDispClass = $modalOptions['sizeDispClass'] ?? 'col-sm-12';
$posDispClass = $modalOptions['posDispClass'] ?? 'col-sm-8';
$zoomEnabled = $modalOptions['zoomEnabled'] ?? true;
$rotateEnabled = $modalOptions['rotateEnabled'] ?? true;
$flipEnabled = $modalOptions['flipEnabled'] ?? true;
$scrollEnabled = $modalOptions['scrollEnabled'] ?? true;
$showHelp = $modalOptions['showHelp'] ?? true;

?>
<div class="modal fade" tabindex="-1" role="dialog" id="cropper-modal-<?= $unique ?>" aria-hidden="true">
    <div class="modal-dialog <?= $modalClass ?>" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabel-<?= $unique ?>"><?= $modalLabel ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <div class="modal-canvas <?= $canvasClass ?>"><img id="cropper-image-<?= $unique ?>" src="" alt=""></div>
                <div class="<?= $panelClass ?>">
                    <div class="row ms-2">
                        <?php if ($sizeDisp) : ?>
                            <div class="<?= $sizeDispClass ?>">
                                <div class="input-group input-group-sm width-warning mb-2">
                                    <label class="input-group-text"
                                           for="dataWidth-<?= $unique ?>"><?= Yii::t('cropper', 'Width') ?>
                                        (<?= $cropWidth ?>
                                        px)</label>
                                    <input type="text" class="form-control text-end" id="dataWidth-<?= $unique ?>"
                                           placeholder="width"><span class="input-group-text">px</span>
                                </div>
                            </div>
                            <div class="<?= $sizeDispClass ?>">
                                <div class="input-group input-group-sm height-warning mb-2">
                                    <label class="input-group-text"
                                           for="dataHeight-<?= $unique ?>"><?= Yii::t('cropper', 'Height') ?>
                                        (<?= $cropHeight ?>
                                        px)</label>
                                    <input type="text" class="form-control text-end" id="dataHeight-<?= $unique ?>"
                                           placeholder="height"><span
                                            class="input-group-text">px</span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($posDisp) : ?>
                            <div class="<?= $posDispClass ?>">
                                <div class="input-group input-group-sm mb-2">
                                    <label class="input-group-text" for="dataX-<?= $unique ?>">X</label>
                                    <input type="text" class="form-control text-end" id="dataX-<?= $unique ?>"
                                           placeholder="x"><span
                                            class="input-group-text">px</span>
                                </div>
                            </div>
                            <div class="<?= $posDispClass ?>">
                                <div class="input-group input-group-sm mb-2">
                                    <label class="input-group-text" for="dataY-<?= $unique ?>">Y</label>
                                    <input type="text" class="form-control text-end" id="dataY-<?= $unique ?>"
                                           placeholder="y"><span
                                            class="input-group-text">px</span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="col-sm-12 mt-2">
                        <span class="btn btn-primary btn-file me-1 mb-2"><?= $browseLabel ?>
                            <input type="file" id="cropper-input-<?= $unique ?>"
                                   title="<?= Yii::t('cropper', 'Browse') ?>" accept="image/*">
                        </span>
                            <?php if ($zoomEnabled) : ?>
                                <div class="btn-group me-1 mb-2">
                                    <button type="button"
                                            class="btn btn-primary zoom-in"><?= $cropperOptions['icons']['zoom-in'] ?></button>
                                    <button type="button"
                                            class="btn btn-primary zoom-out"><?= $cropperOptions['icons']['zoom-out'] ?></button>
                                </div>
                            <?php endif; ?>
                            <?php if ($rotateEnabled || $flipEnabled) : ?>
                                <div class="btn-group me-1 mb-2">
                                    <?php if ($rotateEnabled) : ?>
                                        <button type="button"
                                                class="btn btn-primary rotate-left"><?= $cropperOptions['icons']['rotate-left'] ?></button>
                                        <button type="button"
                                                class="btn btn-primary rotate-right"><?= $cropperOptions['icons']['rotate-right'] ?></button>
                                    <?php endif; ?>
                                    <?php if ($flipEnabled) : ?>
                                        <button type="button"
                                                class="btn btn-primary flip-horizontal"><?= $cropperOptions['icons']['flip-horizontal'] ?></button>
                                        <button type="button"
                                                class="btn btn-primary flip-vertical"><?= $cropperOptions['icons']['flip-vertical'] ?></button>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($scrollEnabled) : ?>
                                <div class="btn-group me-1 mb-2">
                                    <button type="button"
                                            class="btn btn-primary move-left"><?= $cropperOptions['icons']['move-left'] ?></button>
                                    <button type="button"
                                            class="btn btn-primary move-right"><?= $cropperOptions['icons']['move-right'] ?></button>
                                    <button type="button"
                                            class="btn btn-primary move-up"><?= $cropperOptions['icons']['move-up'] ?></button>
                                    <button type="button"
                                            class="btn btn-primary move-down"><?= $cropperOptions['icons']['move-down'] ?></button>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-sm-12 mt-2 text-end">
                            <button type="button" id="crop-button-<?= $unique ?>"
                                    class="btn btn-success mb-2 me-1"
                                    data-bs-dismiss="modal"><?= $cropLabel ?></button>
                            <button type="button" id="cancel-button-<?= $unique ?>"
                                    class="btn btn-outline-secondary mb-2"
                                    data-bs-dismiss="modal"><?= $cancelLabel ?></button>
                        </div>
                        <?php if ($showHelp): ?>
                            <div class="col-sm-12 mt-2">
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <p><strong><?= Yii::t('cropper', 'Mouse wheel') ?></strong>
                                        : <?= Yii::t('cropper', 'Zoom') ?></p>
                                    <p><strong><?= Yii::t('cropper', 'Outside cropping rect') ?></strong> :<br/>
                                        <strong><?= $cropperOptions['icons']['cursor-cross-hair'] ?></strong>
                                        = <?= Yii::t('cropper', 'Set rect') ?><br/>
                                        <strong><?= $cropperOptions['icons']['cursor-scroll'] ?></strong>
                                        = <?= Yii::t('cropper', 'Scroll image') ?><br/>
                                        <?= Yii::t('cropper', '(Double click to change mode)') ?></p>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"
                                            tabindex="-1"></button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
