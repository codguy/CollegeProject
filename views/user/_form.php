<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TblUser */
/* @var $form yii\widgets\ActiveForm */
?>


<main class="d-flex w-100">
	<div class="container d-flex flex-column">
		<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
			<div class="d-table-cell align-middle">

				<?php  $form = ActiveForm::begin([
                    'id' => 'signup-form',
                    'options' => [
                        'enctype' => 'multipart/form-data'
                    ],
                    'fieldConfig' => [
                        'template' => "{label}\n{input}\n{error}",
                        'labelOptions' => [
                            'class' => 'col-form-label mr-lg-3'
                        ],
                        'inputOptions' => [
                            'class' => 'form-control'
                        ],
                        'errorOptions' => [
                            'class' => 'invalid-feedback'
                        ]
                    ]
                ]);
                ?>
				<div class="card">
					<div class="card-body">
						<div class="m-sm-4">
							<div class="text-center">
								<?php
                                    if (! empty($model->profile_picture)) {
                                        echo '<img src=' . $model->getImageUrl() . ' alt="Charles Hall" class="img-fluid rounded-circle" width="132" height="132" />';
                                    } else {
                                        echo '<img src="images/user-icon.png" class="img-fluid rounded-circle" width="132" height="132" />';
                                    }
                                ?>
							</div>

							<div class="mb-3">
                                    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                                </div>
							<div class="mb-3">
                                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                                </div>
							<div class="mb-3">
                                    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'minlength' => true]) ?>
                                </div>
							<div class="mb-3">
                                    <?= $form->field($model, 'roll_id')->dropDownList($model->getRoleOption()) ?>
                                </div>
							<div class="mb-3">
                                    <?= $form->field($model, 'dob')->textInput(['type' => 'date'])?>
                                </div>
                                <div class="mb-3">
                                 <?= $form->field($model, 'gender',['template' => '{label}'])->textInput() ?>
                                <?= $form->field($model, 'gender',['template' => '<div class ="Radio-btn">{input}Male</div>'])->textInput(['type'=>'radio', 'value' => 'Male']) ?>
                                <?= $form->field($model, 'gender', ['template' => '<div class ="Radio-btn">{input}Female</div>'])->textInput(['type'=>'radio', 'value' => 'Female']) ?>
                                </div>
								<div class="mb-3">
                                    <?= $form->field($model, 'profile_picture', ['template' => '{input}'])->fileInput()?>
                                </div>
							<div class="text-center mt-3">

								<div class="form-group">
                                        <?= Html::submitButton(Yii::t('app', 'Create User'), ['class' => 'btn btn-success login-btns']) ?>
                                    </div>
							</div>
                        <?php ActiveForm::end(); ?>
                                
                        </div>

					</div>
				</div>

			</div>
		</div>
	</div>
</main>
