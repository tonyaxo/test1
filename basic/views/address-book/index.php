<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AddressBookFinder */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $userId int */

?>
<div class="address-book-index">

    <h1><?= Html::encode(Yii::t('app', 'Addresses')) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Address'), ['/address-book/create', 'userId' => $userId], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'value',

            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'address-book',
                'template' =>  '{update} {delete}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
