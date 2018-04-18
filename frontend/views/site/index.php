<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <?= $this->render('_report_form', [
        'model' => $model,
    ]) ?>

</div>
