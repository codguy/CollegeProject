<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\TblUser;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

// // $this->title = 'Tbl Users';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-user-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email:email',
//             'password',
            'roll_id',
            'state_id',
            'dob',
            //'created_on',
            //'created_by_id',
            //'authKey',
            //'accessToken',
            'gender',
            //'profile_picture',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TblUser $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
