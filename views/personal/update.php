<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="user-update">

    <h1>Редактирвание профиля</h1>

	<div class="user-form">

	    <?php $form = ActiveForm::begin(); ?>

	    <?php //$form->field($oUser, 'email')->textInput(['maxlength' => 250]) ?>

	    <?= $form->field($oUser, 'name')->textInput(['maxlength' => 250]) ?>

	    <?= $form->field($oUser, 'surname')->textInput(['maxlength' => 250]) ?>

	    <?= $form->field($oUser, 'pass')->passwordInput(['maxlength' => 250]) ?>

	    <?= $form->field($oUser, 'passRepeat')->passwordInput(['maxlength' => 250]) ?>

	    <div class="form-group">
	        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>


</div>
