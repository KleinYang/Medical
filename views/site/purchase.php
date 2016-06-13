<?php

/* @var $this yii\web\View */
/* @var $purchases app\models\Purchase */
/* @var $product app\models\PurchaseDetail */
//use app\assets\AppAsset;
$this->title = '采购订单';

?>
<style media="screen">
  .addPurchase{
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
   #detail {
      white-space: nowrap;
   }
</style>
<div class="row">
  <div class="col-lg-12">
    <h1>采购订单列表</h1>
    <table class="table table-striped table-hover1" id="product">
      <caption>采购订单</caption>
      <thead>
        <tr>
          <th>采购订单批次</th>
          <th>负责人</th>
          <th>负责人电话</th>
          <th>发票号</th>
          <th>总价</th>
          <th>销账状态</th>
        </tr>
      </thead>
      <tbody>
        <?php  foreach ($purchases as $v): ?>
        <?php $details = $v['detail']; ?>
        <tr>
          <td id="<?= 'batch_'.$v['order']->purchase_id ?>"><?php echo $v['order']->purchase_batch; ?></td>
          <td id="<?= 'contact_'.$v['order']->purchase_id ?>"><?php echo $v['order']->purchase_contact_name; ?></td>
          <td id="<?= 'call_'.$v['order']->purchase_id ?>"><?php echo $v['order']->purchase_contact_call; ?></td>
          <td id="<?= 'billcode_'.$v['order']->purchase_id ?>"><?php echo $v['order']->purchase_bill_code; ?></td>
          <td id="<?= 'total_'.$v['order']->purchase_id ?>"><?php echo $v['order']->purchase_total_money; ?></td>
          <td id="<?= 'status_'.$v['order']->purchase_id ?>">
            <?php
              if ($v['order']->purchase_status == 0) {
                  echo '未销账';
              } elseif ($v['order']->purchase_status == 1) {
                  echo '已销账';
              }
            ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <span>
      <a href="?r=site/addpurchase"><span class="btn btn-primary pull-right addPurchase">增加采购订单</span></a>
    </span>
  </div>
</div>

<div class="col-lg-12">
      <table class="table table-striped" id="detail">
      <caption>采购订单明细</caption>
      <thead>
        <tr>
          <th>单号</th>
          <th>生产商</th>
          <th>产品</th>
          <th>通用名</th>
          <th>流通商</th>
          <th>供应商</th>
          <th>单价</th>
          <th>数量</th>
          <th>总金额</th>
          <th>剩余数量</th>
        </tr>
      </thead>
      <tbody class="more-modal-body">
        
      </tbody>
    </table>
</div>

<script>
  document.getElementsByTagName('table')[0].onclick = function(ev) {
    var purchase_id = ev.target.id.split('_')[1];

    jQuery.ajax({
            url: "?r=site/purchasedetail",
            method: 'POST',
            dataType: 'json',
            data: {
                function: true,
                purchase_id: purchase_id,
            },
            success: function(resp)
            {
              var purchaseDetailInfo = '';
              for(var key in resp) {
                purchaseDetailInfo = purchaseDetailInfo + 
                '<tr>'+
                  '<td>'+resp[key].purchase_batch+'</td>'+
                  '<td>'+resp[key].manufacture_name+'</td>'+
                  '<td>'+resp[key].product_name+'</td>'+
                  '<td>'+resp[key].product_chemical_name+'</td>'+
                  '<td>'+resp[key].channel_name+'</td>'+
                  '<td>'+resp[key].supplier_name+'</td>'+
                  '<td>'+resp[key].price+'</td>'+
                  '<td>'+resp[key].product_num+'</td>'+
                  '<td>'+resp[key].purchase_detail_total_money+'</td>'+
                  '<td>'+resp[key].product_residue_num+'</td>'+
                '</tr>';
              }
              $(".more-modal-body").html(purchaseDetailInfo);
            }
    });
  }

jQuery(document).ready(function($){
  oTable = $('#product').dataTable();
});
</script>
