<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserFinder */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'last_name',
            [
                'attribute' => 'birthDay',
                'format' => 'date',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'birthDay',
                    'language' => 'ru',
                    'dateFormat' => Yii::$app->formatter->dateFormat,
                    'options' => ['class' => 'form-control'],
                ]),
            ],
            [
                'attribute' => 'sex',
                'filter' => \app\models\User::getSexFiler(),
                'value' => function ($model) {
                    $values = \app\models\User::getSexFiler();
                    if (isset($values[$model->sex])) {
                        return $values[$model->sex];
                    }
                    return null;
                }
            ],
            'phone_number',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' =>  '{update} {delete}',
            ],
        ],
    ]); ?>
</div>
