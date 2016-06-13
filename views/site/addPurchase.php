<?php
use yii\widgets\ActiveForm;
use app\assets\AppAsset;
use yii\helpers\Html;
use yii\app;

/* @var $this yii\web\View */
/* @var $model app\models\AddOrderForm */
/* @var $product app\models\Product */
/* @var $form ActiveForm */

$this->title = '采购';
?>
<style media="screen">
   .addProduct{
     margin: 10px;
   }

   .table-responsive {
         width:100%;
         margin-bottom: 15px;
         overflow: auto;
         -webkit-overflow-scrolling:touch;
         -ms-overflow-style:-ms-autohiding-scrollbar;
      }
   .table-responsive >.table{margin-bottom: 0;}
   .table-responsive>.table-bordered{border:0;}

   .table-responsive > .table > thead > tr > th, 
   .table-responsive > .table > thead > tr > td {
      white-space:nowrap;
   }
   #product {
      white-space:nowrap;
   }

   #addorderform-clienttype {
      width:20%;
      margin:0;  
      padding:0;  
      display:inline-block;  
      _display:inline;  
      *display:inline;  
      zoom:1;  
   }

   #addorderform-clientprovince {
      width:20%;
      margin:0;  
      padding:0;  
      display:inline-block;  
      _display:inline;  
      *display:inline;  
      zoom:1; 
   }

   #addorderform-client {
      width:20%;
   }
</style>
<div class="row">
  <div class="col-lg-10">
  <?php $form = ActiveForm::begin([
      'id' => 'add-order-form',
      'options' => ['class' => 'form-horizontal'],
  ]); ?>
      <caption>产品目录</caption>
      <?= $form->field($model, 'purchaseContactName' )->textInput(['label' => '', 'value' => $model->getUser(Yii::$app->user->id)['username'] ])->label('联系人姓名') ?>
      <?= $form->field($model, 'purchaseContactCall' )->textInput(['label' => '', 'value' => $model->getUser(Yii::$app->user->id)['tel'] ])->label('联系人电话') ?>
      <?= $form->field($model, 'purchaseBillCode' )->label('发票号') ?>
      <?= $form->field($model, 'productBatch' )->label('产品批次') ?>
      <div class="table-responsive">
      <table class="table" id="product" >
        <thead>
          <tr>
            <th>选择</th>
            <th>产品名称</th>
            <th>通用名</th>
            <th>生产商</th>
            <th>渠道商</th>
            <th>供应商</th>
            <th>含税采购价</th>
            <th>采购价</th>
            <th>含税零售价</th>
            <th>零售价</th>
            <th>含税批发价</th>
            <th>批发价</th>
            <th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp价格&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
            <th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp购买&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
            <th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp指导价&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $product): ?>
            <tr id="<?= $product->product_id?>">
              <td><input type="checkbox" name="checkbox" value="<?= $product->product_id?>"></td>
              <td><?php echo $product->product_name; ?></td>
              <td><?php echo $product->product_chemical_name; ?></td>
              <td><?php echo $product->getClient($product->client_manufacture_id)['client_name']; ?></td>
              <td><?= $form->field($model, 'channel[]')->dropDownList($product->getChannel($product->product_name), array('class' => 'col-lg-18 col-lg-offset-0', 'id' => $product->product_id.'-channel'))->label('') ?></td>
              <td><?= $form->field($model, 'supplier[]')->dropDownList($product->getSupplier($product->product_name), array('class' => 'col-lg-18 col-lg-offset-0', 'id' => $product->product_id.'-supplier'))->label('') ?></td>
              <td><?= $product->purchase_unit_price?></td>
              <td><?= $product->purchase_price?></td>
              <td><?= $product->retail_unit_price?></td>
              <td><?= $product->retail_price?></td>
              <td><?= $product->trade_unit_price?></td>
              <td><?= $product->trade_price?></td>
              <td><?= $form->field($model, 'productPrice[]')->textInput(array('class' => 'col-lg-6 col-lg-offset-3', 'value' => $product->purchase_unit_price, 'id' => $product->product_id.'-price'))->label('') ?></td>
              <td><?= $form->field($model, 'productNum[]')->textInput(array('class' => 'col-lg-6 col-lg-offset-3', 'value' => 0, 'id' => $product->product_id.'-num'))->label('') ?>
                <?= $form->field($model, 'productId[]')->textInput(['label' => '', 'value' => $product->product_id, 'type' => 'hidden'])->label(''); ?></td>
              <td><input type="text" name="guidePice" id="<?= 'guidePrice'.$product->product_id?>" readOnly='true' class = 'col-lg-6 col-lg-offset-3'></td>  
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
      <div class="form-group">
          <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
          <input type="button" id="btn5" value="生成订单">
          <a href="#" onClick="javascript :history.back(-1);">返回</a>
      </div>
    <?php ActiveForm::end(); ?>
  </div>
</div>

<div  class="table-responsive">
  <table  class="table">
    <thead>
      <tr>
        <th>产品名称</th>
        <th>通用名</th>
        <th>生产商</th>
        <th>渠道商</th>
        <th>供应商</th>
        <th>价格</th>
        <th>购买</th>
        <th>指导价</th>
      </tr>
    </thead>
    <tbody class="more-modal-body">

    </tbody>
  </table>
</div>



<script>

jQuery(document).ready(function($){
  oTable = $('#product').dataTable();
});

document.getElementsByTagName('table')[0].onchange = function(ev) {
  if(ev.target.id >= '0' && ev.target.id <= '9-price') {
    var purchase_detail_id = ev.target.id.split('-')[0];
    var price_id = purchase_detail_id + '-price';
    var num_id = purchase_detail_id + '-num';
    var price = document.getElementById(price_id).value;
    var num = document.getElementById(num_id).value;

    var guidePrice_id = 'guidePrice' + purchase_detail_id;
    document.getElementById(guidePrice_id).value = price*num;
  }
}
$(document).ready(function(){
  $("#btn5").click(function(){
    var product_id;
    document.getElementsByClassName('more-modal-body')[0].innerHTML = '';
    $("input:checkbox[name=checkbox]:checked").each(function(){
     product_id=$(this).val();
     var table = document.getElementsByClassName('more-modal-body')[0];
     var channel_id = document.getElementById(product_id+"-channel").value;
     var supplier_id = document.getElementById(product_id+"-supplier").value;
     var price = document.getElementById(product_id+"-price").value;
     var num = document.getElementById(product_id+"-num").value;
     var guidePrice = document.getElementById('guidePrice'+product_id).value;
     $.ajax({
        url: "?r=site/purchasecart",
        type: 'POST',
        dataType: 'json',
        data: {
          product_id: product_id,
          channel_id: channel_id,
          supplier_id: supplier_id,
        },
        success: function(resp) {
          //console.log(resp);
          table.innerHTML += '<tr>'+
            '<td>' + resp['product_name'] + '</td>' +
            '<td>' + resp['product_chemical_name'] + '</td>' +
            '<td>' + resp['manufacture'] + '</td>' +  
            '<td>' + resp['channel'] + '</td>' +
            '<td>' + resp['supplier'] + '</td>' +
            '<td>' + price + '</td>' +
            '<td>' + num + '</td>' +
            '<td>' + guidePrice + '</td>' 
           + '</tr>';
            
        }
      });

     
    });
  });
});
</script>

