<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sex')->dropDownList(
        \app\models\User::getSexFiler(),
        ['prompt' => Yii::t('app', 'Select sex')
    ]) ?>

    <?= $form->field($model, 'birthDay')->widget(\yii\jui\DatePicker::class, [
        'language' => 'ru',
        'dateFormat' => Yii::$app->formatter->dateFormat,
        'options' => ['class' => 'form-control'],
    ])  ?>

    <?= $form->field($model, 'phone_number')->widget(\yii\widgets\MaskedInput::class, [
        'mask' => '+7 (999) 999-9999',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
