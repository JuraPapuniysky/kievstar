<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\CallForm */
/* @var $form ActiveForm */
?>
<div class="find-report">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'month') ?>
        <?= $form->field($model, 'year') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Згенерувати звіт', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- _find-report -->
