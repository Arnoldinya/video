<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $oUser app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($oUser, 'email')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($oUser, 'name')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($oUser, 'surname')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($oUser, 'pass')->passwordInput(['maxlength' => 250]) ?>

    <?= $form->field($oUser, 'passRepeat')->passwordInput(['maxlength' => 250]) ?>

    <div class="form-group">
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>