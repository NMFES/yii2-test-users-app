<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserTransfersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Transfers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-transfers-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-transfers-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Username',
                'attribute' => 'user.username',
            ],
            [
                'attribute' => 'amount',
                'value' => function($model, $key, $index, $widget) {
                    return ($model->to_user_id == Yii::$app->user->id ? '+' : '-') . $model->amount;
                }
            ],
        ],
    ]);
    ?>
</div>