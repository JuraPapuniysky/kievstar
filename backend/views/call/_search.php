<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CallSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="call-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'date_time') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'call_directions') ?>

    <?= $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'cost_balance') ?>

    <?php // echo $form->field($model, 'cost') ?>

    <?php // echo $form->field($model, 'catalog_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'file_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
