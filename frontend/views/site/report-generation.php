<?php

/* @var $model \frontend\models\CallForm */

?>
<div class="report-generation">

    <div class="row">
        <div class="col-md-6">
            <?= $this->render('_find-report', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

    <?php if ($calls !== null){ ?>
        <pre>
            <?php print_r($calls) ?>
        </pre>
     <?php } ?>

</div>
