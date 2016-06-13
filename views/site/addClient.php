<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;

/* @var $this yii\web\View */
/* @var $model app\models\AddClientForm */
/* @var $form ActiveForm */

$this->title = '添加客户';
$level = array('无', '甲', '乙', '丙');
$grade = array('无', '一', '二', '三');
$type = array(
    '医院'     => '医院',
    '生产厂商' => '生产厂商',
    '个人'     => '个人',
    '供应商'   => '供应商',
    '流通商'   => '流通商',
    '其他'     => '其他',
    )
?>
<div class="row addClient col-lg-8 col-lg-offset-2 well">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'name')->label('客户名') ?>
        <?= $form->field($model, 'alias')->label('客户别名') ?>
        <?= $form->field($model, 'contact')->label('联系人') ?>
        <?= $form->field($model, 'regionProvince')->dropDownList($regionProvinces)->label('省份') ?>
        <?= $form->field($model, 'regionCity')->dropDownList([])->label('县级') ?>
        <?= $form->field($model, 'regionCountry')->dropDownList([])->label('市级') ?>
        <?= $form->field($model, 'detailAddress')->label('具体地址') ?>
        <?= $form->field($model, 'type')->dropDownList($type)->label('客户类型') ?>
        <?= $form->field($model, 'tel')->label('联系电话') ?>
        <?= $form->field($model, 'email')->label('邮箱') ?>
        <?= $form->field($model, 'bank_account')->label('银行账户') ?>
        <?= $form->field($model, 'memo')->label('备注') ?>
        <?= $form->field($model, 'bussiness_info')->label('工商信息') ?>
        <?= $form->field($model, 'level')->dropDownList($level)->label('级别') ?>
        <?= $form->field($model, 'grade')->dropDownList($grade)->label('等级') ?>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
            <a href="#" onClick="javascript :history.back(-1);">返回</a>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- addClient -->

<script>
    function getReion(parentId,tag){
  $.ajax({
    url: "?r=site/getregion",
    type: 'POST',
    dataType: 'json',
    data: {
      parentId: parentId
    },
    success: function(data, status) {
      $(tag).html("");
      $.each(data, function(index, address) {
        $(tag).append("<option value=" + address['id'] + ">" + address['name'] + "</option>");
      });
    }
  });
}

jQuery(document).ready(function($){
  getReion($("#addclientform-regionprovince").val(),"#addclientform-regioncity");
  $("#addclientform-regionprovince").bind('change', function() {
    getReion($(this).val(),"#addclientform-regioncity");
  });
  $("#addclientform-regioncity").bind('click',function (){
    getReion($(this).val(),"#addclientform-regioncountry");
  });
});
</script>
