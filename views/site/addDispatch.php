<?php
use yii\widgets\ActiveForm;
use app\assets\AppAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AddOrderForm */
/* @var $form ActiveForm */

$this->title = '调度';
?>
<style media="screen">
   .addProduct{
     margin: 10px;
   }

   .table-responsive {
         width:100%;
         margin-bottom: 15px;
         overflow: scroll;
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

   #detail {
      white-space:nowrap;
   }
</style>
<div class="row">
  <div class="col-lg-12">
  <?php $form = ActiveForm::begin([
      'id' => 'add-order-form',
      'options' => ['class' => 'form-horizontal'],
  ]); ?>
      <caption>商品目录</caption>
      
      <div class="row">
        <div class="col-lg-3" style="margin:10px">
          <?= $form->field($model, 'clientType')
          ->dropDownList($clients['type'])
          ->label('调度厂商类型') ?>
        </div>

        <div class="col-lg-3" style="margin:10px">
          <?= $form->field($model, 'clientProvince')
          ->dropDownList($province)
          ->label('调度厂商省份') ?>
        </div>

        <div class="col-lg-3" style="margin:10px">
          <?= $form->field($model, 'client')
          ->dropDownList([])->label('调度厂商') ?>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-5" style="margin:10px">
          <?= $form->field($model, 'productBatch' )
          ->label('产品调度批次') ?>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-5" style="margin:10px">
          <?= $form->field($model, 'purchaseBillCode' )
          ->label('发票号') ?>
        </div>
      </div>

      <div class="table-responsive">
      <table class="table table-striped" id="product" >
        <thead>
          <tr>
            <th>选择</th>
            <th>&nbsp&nbsp&nbsp&nbsp&nbsp批次&nbsp&nbsp&nbsp&nbsp&nbsp</th>
            <th>&nbsp&nbsp&nbsp&nbsp&nbsp商品名称&nbsp&nbsp&nbsp&nbsp&nbsp</th>
            <th>&nbsp&nbsp&nbsp&nbsp&nbsp商品别名&nbsp&nbsp&nbsp&nbsp&nbsp</th>
            <th>&nbsp&nbsp&nbsp&nbsp&nbsp生产厂商&nbsp&nbsp&nbsp&nbsp&nbsp</th>
            <th>&nbsp&nbsp&nbsp&nbsp&nbsp数量&nbsp&nbsp&nbsp&nbsp&nbsp</th>
            <th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp价格&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
            <th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp购买&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
            <th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp渠道成本&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
            <th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp利润&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
            <th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp专户结算总额&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
            <th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp零售指导价&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
          </tr>
        </thead>
        <tbody>
          <?php  foreach ($products as $v): ?>
          <?php $details = $v['detail']; ?>
          <?php foreach ($details as $product): ?>
          <?php if($product->product_residue_num>0): ?>
            <tr>
              <td><input type="checkbox" name="checkbox" value="<?= $product->purchase_detail_id?>"></td>
              <td>
                <?php echo $v['order']->purchase_batch ?>
              </td>

              <td>
                <?php echo $product->getProduct($product->product_id)['product_name']; ?>
              </td>

              <td>
                <?php echo $product->
                getProduct($product->product_id)['product_chemical_name']; ?>
              </td>

              <td>
                <?php echo $product->
                getManufacturerByProduct($product->product_id)['client_name']; ?>
              </td>

              <td>
                <?php echo $product->product_residue_num; ?>
              </td>

              <td>
                <?= $form->field($model, 'productPrice[]')
                ->textInput(array('class' => 'col-lg-6 col-lg-offset-3',
                 'value' => $product->getProduct($product->product_id)['trade_unit_price'],
                  "id" => $product->purchase_detail_id.'-price'))->label('') ?>
              </td>

              <td>
                <?= $form->field($model, 'productNum[]')
                ->textInput(array('class' => 'col-lg-6 col-lg-offset-3', 
                'value' => 0,  "id" => $product->purchase_detail_id.'-num'))
                ->label('') ?>

                <?= $form->field($model, 'productId[]')
                ->textInput(['class' => 'col-lg-6 col-lg-offset-3', 
                'label' => '', 'value' => $product->purchase_detail_id, 
                'type' => 'hidden'])->label(''); ?>
              </td>

              <td>
                <?= $form->field($model, 'productChannelCost[]')
                ->textInput(['class' => 'col-lg-6 col-lg-offset-3', 
                'label' => '', "id" => 'cost'.$product->purchase_detail_id])
                ->label(''); ?>
              </td>

              <td>
                <?= $form->field($model, 'productProfit[]')
                ->textInput(['class' => 'col-lg-6 col-lg-offset-3', 
                'label' => '', "id" => 'profit'.$product->purchase_detail_id])
                ->label(''); ?>
              </td>

              <td>
                <?= $form->field($model, 'totalAccounts[]')
                ->textInput(['class' => 'col-lg-6 col-lg-offset-3', 
                'label' => '', "id" => 'account'.$product->purchase_detail_id])
                ->label(''); ?>
              </td>

              <td>
                <input type="text" name="guidePice" id=
                "<?= 'guidePrice'.$product->purchase_detail_id?>" 
                readOnly='true' class = 'col-lg-6 col-lg-offset-3'>
              </td>
            </tr>
          <?php endif; ?>
          <?php endforeach; ?>
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
  <table  class="table" id="detail">
    <thead>
      <tr>
        <th>&nbsp&nbsp&nbsp&nbsp&nbsp批次&nbsp&nbsp&nbsp&nbsp&nbsp</th>
        <th>&nbsp&nbsp&nbsp&nbsp&nbsp商品名称&nbsp&nbsp&nbsp&nbsp&nbsp</th>
        <th>&nbsp&nbsp&nbsp&nbsp&nbsp商品别名&nbsp&nbsp&nbsp&nbsp&nbsp</th>
        <th>&nbsp&nbsp&nbsp&nbsp&nbsp生产厂商&nbsp&nbsp&nbsp&nbsp&nbsp</th>
        <th>&nbsp&nbsp&nbsp&nbsp&nbsp数量&nbsp&nbsp&nbsp&nbsp&nbsp</th>
        <th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp价格&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
        <th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp购买&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
        <th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp渠道成本&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
        <th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp利润&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
        <th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp专户结算总额&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
        <th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp零售指导价&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
      </tr>
    </thead>
    <tbody class="more-modal-body">

    </tbody>
  </table>
</div>

<script>
$(document).ready(function(){
  oTable = $('#product').dataTable();

  $("#btn5").click(function(){
    var product_id;
    document.getElementsByClassName('more-modal-body')[0].innerHTML = '';
    $("input:checkbox[name=checkbox]:checked").each(function(){
     product_id=$(this).val();
     var table = document.getElementsByClassName('more-modal-body')[0];
     var price = document.getElementById(product_id+"-price").value;
     var num = document.getElementById(product_id+"-num").value;
     var cost = document.getElementById("cost"+product_id).value;
     var profit = document.getElementById("profit"+product_id).value;
     var account = document.getElementById("account"+product_id).value;
     var guidePrice = document.getElementById("guidePrice"+product_id).value;

     $.ajax({
        url: "?r=site/ordercart",
        type: 'POST',
        dataType: 'json',
        data: {
          product_id: product_id,
        },
        success: function(resp) {
          //console.log(resp);
          table.innerHTML += '<tr>'+
           '<td>' + resp['batch'] + '</td>' +
           '<td>' + resp['product_name'] + '</td>' +
           '<td>' + resp['product_chemical_name'] + '</td>' +
           '<td>' + resp['manufacture'] + '</td>' +
           '<td>' + resp['product_residue_num'] + '</td>' +
           '<td>' + price + '</td>' +
           '<td>' + num + '</td>' +
           '<td>' + cost + '</td>' +
           '<td>' + profit + '</td>' +
           '<td>' + account + '</td>' +
           '<td>' + guidePrice + '</td>' +
           '</tr>';
        }
      });
    });
  });

  $(function() {
//  getClient($("#addorderform-clienttype").val(), $("#addorderform-clientprovince").val(), "#addorderform-client");
  $("#adddispatchform-clienttype").bind('click', function() {
    getClient($(this).val(),$("#adddispatchform-clientprovince").val(),"#adddispatchform-client");
  });
  $("#adddispatchform-clientprovince").bind('click', function() {
    getClient($("#adddispatchform-clienttype").val(),$("#adddispatchform-clientprovince").val(),"#adddispatchform-client");
  });

 // getClient($("#adddispatchform-recommandclienttype").val(),"#adddispatchform-recommandclient");
  $("#adddispatchform-recommandclienttype").bind('click', function() {
    getClient($("#adddispatchform-recommandclienttype").val(),$("#adddispatchform-recommandclientprovince").val(),"#adddispatchform-recommandclient");
  });
  $("#adddispatchform-recommandclientprovince").bind('click', function() {
    getClient($("#adddispatchform-recommandclienttype").val(),$("#adddispatchform-recommandclientprovince").val(),"#adddispatchform-recommandclient");
  });
});
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

    jQuery.ajax({
      url: "?r=site/compute",
      method: 'POST',
      dataType: 'json',
      data: {
          function: true,
          purchase_detail_id: purchase_detail_id,
          price: price,
          num: num,
      },
      success: function(resp)
      {
        console.log(resp);
        var cost_id = 'cost'+ purchase_detail_id;
        var profit_id = 'profit'+ purchase_detail_id;
        var account_id = 'account'+ purchase_detail_id;
        document.getElementById(cost_id).value = resp.cost;
        document.getElementById(profit_id).value = resp.profit;
        document.getElementById(account_id).value = resp.accounts;
      }
    });


  }
}

function getClient(clientType,clientProvince,tag){
  $.ajax({
    url: "?r=site/getclient",
    type: 'POST',
    dataType: 'json',
    data: {
      clientType: clientType,
      clientProvince: clientProvince,
    },
    success: function(data, status) {
      console.log(data);
      $(tag).html("");
      $.each(data, function(index, client) {
        if(client == null) {
          $(tag).innerHTML = '';
        }else {
          $(tag).append("<option value=" + client['id'] + ">" + client['name'] + "</option>");
        }
        
      });
    }
  });
}




</script>

