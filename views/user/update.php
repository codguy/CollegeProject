<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TblUser */
?>
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="main-breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><?= Html::a('Home', ['site/index']) ?></li>
		<li class="breadcrumb-item"><?= Html::a('Users', ['index']) ?></li>
		<li class="breadcrumb-item"><?= Html::a($model->username, ['view', 'id' => $model->id]) ?></li>
		<li class="breadcrumb-item active" aria-current="page">Update</li>
	</ol>
</nav>
<!-- /Breadcrumb -->

<div class="tbl-user-update">

    <?=$this->render('_form', ['model' => $model])?>

</div>
