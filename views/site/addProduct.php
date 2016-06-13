<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\Models\AddProductForm */
/* @var $form ActiveForm */

$this->title = '添加产品';
?>
<div class="row">
  <div class="addProduct col-lg-8 col-lg-offset-2 well">
    <h4>添加产品</h4>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'name')->label('产品名称') ?>
    <?= $form->field($model, 'chemical_name')->label('通用名') ?>
    <?= $form->field($model, 'manufacturer')->dropDownList($manufacturers)->label('生产厂家') ?>
    <?= $form->field($model, 'repositories')->dropDownList($repositories)->label('渠道商') ?>
    <?= $form->field($model, 'suppliers')->dropDownList($suppliers)->label('供应商') ?>
    <?= $form->field($model, 'specification')->label('规格') ?>
    <?= $form->field($model, 'purchasePrice')->label('采购价') ?>
    <?= $form->field($model, 'purchaseUnitPrice')->label('含税采购价') ?>
    <?= $form->field($model, 'retailPrice')->label('零售价') ?>
    <?= $form->field($model, 'retailUnitPrice')->label('含税零售价') ?>
    <?= $form->field($model, 'tradePrice')->label('批发价') ?>
    <?= $form->field($model, 'tradeUnitPrice')->label('含税批发价') ?>
    <?= $form->field($model, 'validity')->label('有效期') ?>
    <?= $form->field($model, 'file')->fileInput()->label('文件名非中文') ?>
    <br /><br />
    <div class="form-group">
      <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
      <a href="#" onClick="javascript :history.back(-1);">返回</a>
    </div>
    <?php ActiveForm::end(); ?>

  </div>
  <!-- addProduct -->
</div>
