<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \frontend\models\SignupForm */

use yii\web\View;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\enums\PersonType;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="site-signup">
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'person_type')->dropDownList(PersonType::$labels) ?>

                <div class="individual-fields" <?php if ($model->person_type == PersonType::TYPE_ENTITY): ?> style="display: none" <?php endif; ?>>
                    <?= $form->field($model, 'is_businessman')->checkbox() ?>
                </div>

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

                <div class="entity-fields businessman-fields" <?php if ($model->person_type == PersonType::TYPE_INDIVIDUAL && !$model->is_businessman): ?> style="display: none" <?php endif; ?>>
                    <?= $form->field($model, 'inn')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="entity-fields" <?php if ($model->person_type == PersonType::TYPE_INDIVIDUAL): ?> style="display: none" <?php endif; ?>>
                    <?= $form->field($model, 'organization_name')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

<?php
$individualType = PersonType::TYPE_INDIVIDUAL;
$js = <<<JS
let personTypeDropDown = $("#signupform-person_type");
let isBusinessman = $("#signupform-is_businessman");
let entityTypeFields = $('.entity-fields');
let businessmanTypeFields = $('.businessman-fields');
let individualTypeFields = $('.individual-fields');
isBusinessman.change(function() {
   if(isBusinessman.is(':checked')){
        businessmanTypeFields.show();
    }else {
        businessmanTypeFields.hide();
        clearDescriptionFields(businessmanTypeFields);
    }
});
personTypeDropDown.on("change", function() {
    if($(this).val() !=='$individualType') {
        isBusinessman.prop("checked",false);
        entityTypeFields.show();
        individualTypeFields.hide();
    }else {
        individualTypeFields.show();
        entityTypeFields.hide();
        clearDescriptionFields(entityTypeFields);
    }
});
function clearDescriptionFields(inputs){
    inputs.each(function() {
      $(this).find('.form-control').val('');
    })
}
JS;
$this->registerJs($js, View::POS_END);
