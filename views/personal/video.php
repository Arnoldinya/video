<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Video */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="video-form">

    <?php $form = ActiveForm::begin([
    	'options' => ['enctype'=>'multipart/form-data']
    ]); ?>

    <?= $form->field($oVideo, 'title')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($oVideo, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($oVideo, 'is_public')->checkBox() ?>

    <?= $form->field($oVideo, 'file_name')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Дабвить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
