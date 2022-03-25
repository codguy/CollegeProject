<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TblUser */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tbl-user-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            'password',
            'roll_id',
            'state_id',
            'dob',
            'created_on',
            'created_by_id',
            'authKey',
            'accessToken',
            'gender',
//             'profile_picture',
            [
                'attribute' => 'Profile_picture',
                'format' => 'raw',
                'value' => function($model){
                    return $model->getImage();
                }
            ]
        ],
    ]) ?>

</div>
