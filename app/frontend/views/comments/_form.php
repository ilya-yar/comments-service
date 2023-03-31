<?php

use yii\bootstrap5\ActiveForm;
use common\models\Comment;
use \yii\helpers\Html;

/* @var $model Comment */

?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'subject')->textInput() ?>
        <?= $form->field($model, 'subject_id')->textInput() ?>
        <?= $form->field($model, 'username')->textInput() ?>
        <?php if (!$model->isNewRecord): ?>
            <?= $form->field($model, 'created_at')->textInput() ?>
        <?php endif; ?>
        <?= $form->field($model, 'comment')->textarea() ?>
    </div>
</div>
<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn ' . ($model->isNewRecord ? 'btn-success' : 'btn-primary'), 'id' => 'success-btn']) ?>
<?php ActiveForm::end(); ?>
