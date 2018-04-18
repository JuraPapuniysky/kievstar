<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ReportForm */
/* @var $form ActiveForm */
?>
<div class="report_form">

    <div class="row">
    <div class="col-md-6">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'month') ?>
        <?= $form->field($model, 'year') ?>
        <?= $form->field($model, 'file')->fileInput() ?>


        <div class="form-group">
            <?= Html::submitButton('Завантажити звіт', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    </div>
    </div>

</div><!-- _report_form -->
