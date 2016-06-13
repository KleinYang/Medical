<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;

/* @var $this yii\web\View */
/* @var $model app\models\AddRepository */
/* @var $form ActiveForm */

$this->title = '添加仓库';
?>
<div class="row">
  <div class="addRepository col-lg-8 col-lg-offset-2 well">
      <h4>添加仓库</h4>
      <?php $form = ActiveForm::begin(); ?>
          <?= $form->field($model, 'name')->label('仓库名称') ?>
          <?= $form->field($model, 'contactName')->label('联系人') ?>
          <?= $form->field($model, 'contactCall')->label('练习电话') ?>
          <?= $form->field($model, 'regionProvince')->dropDownList($regionProvinces)->label('省份') ?>
          <?= $form->field($model, 'regionCity')->dropDownList([])->label('市级') ?>
          <?= $form->field($model, 'regionCountry')->dropDownList([])->label('县级') ?>
          <?= $form->field($model, 'detailAddress')->label('详细地址') ?>
          <div class="form-group">
              <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
              <a href="#" onClick="javascript :history.back(-1);">返回</a>
          </div>
      <?php ActiveForm::end(); ?>
  </div><!-- addRepository -->
</div>
<?php AppAsset::addJsFile($this, '/js/add-repository.js'); ?>
