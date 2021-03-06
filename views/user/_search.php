<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'password') ?>

    <?= $form->field($model, 'roll_id') ?>

    <?php // echo $form->field($model, 'state_id') ?>

    <?php // echo $form->field($model, 'dob') ?>

    <?php // echo $form->field($model, 'created_on') ?>

    <?php // echo $form->field($model, 'created_by_id') ?>

    <?php // echo $form->field($model, 'authKey') ?>

    <?php // echo $form->field($model, 'accessToken') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'profile_picture') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
