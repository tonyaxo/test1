<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AddressBook */
/* @var $user app\models\User */

$this->title = Yii::t('app', 'Update Address: {nameAttribute}', [
    'nameAttribute' => '' . $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Html::encode($user->name), 'url' => ['//user/update', 'id' => $user->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="address-book-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
