<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TblUser */

// $this->title = 'Create Tbl User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<nav aria-label="breadcrumb" class="main-breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><?= Html::a('Home', ['site/index']) ?></li>
		<li class="breadcrumb-item"><?= Html::a('Users', ['index']) ?></li>
		<li class="breadcrumb-item active" aria-current="page">Create</li>
	</ol>
</nav>
<!-- <div class="tbl-user-create"> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

<!-- </div> -->
