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

	<nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><?= Html::a('Home', ['site/index']) ?></li>
              <li class="breadcrumb-item active" aria-current="page">Users</li>
            </ol>
          </nav>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
//         'enableRowClick' => true,
        'layout'=>'{items}{pager}',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
//             'username',
            [
                'attribute' => 'username',
                'format' => 'raw',
                'value' => function($model){
                    return $model->getTableProfile($model);
                }
            ],
            'email:email',
//             'password',
//             'roll_id',
            [
                'attribute' => 'role',
                'value' => function($model){
                return $model->getRole($model->roll_id);
                }
            ],
//             'state_id',
            [
                'attribute' => 'state',
                'value' => function($model){
                return $model->getState($model->state_id);
                }
            ],
            'dob',
//             'created_on',
// //             'created_by_id',
//             [
//                 'attribute' => 'created_by',
//                 'filter' => $searchModel->created_by_id,
//                 'value' => function($model){
//                 return $model->getRole($model->roll_id);
//                 }
//             ],
            //'authKey',
            //'accessToken',
            'gender',
            //'profile_picture',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TblUser $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
//                     return Html::a('button', ['$action']);
                 }
//                 'buttons' => [
//                     'view' => function($name, $model, $key){
//                     return Html::a('<i class="fa fas-eye" aria-hidden="true"></i>', ['update']);
//                     },
//                     'update' => function($name, $model, $key){
//                     return Html::a('<i class="fa fas-pencil-alt" aria-hidden="true"></i>', ['update']);
//                     },
//                     'delete' => function($name, $model, $key){
//                     return Html::a('<i class="fa fas-trash" aria-hidden="true"></i>', ['delete']);
//                     }
//                     ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
