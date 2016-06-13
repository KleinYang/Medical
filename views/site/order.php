<?php

/* @var $this yii\web\View */
/* @var $orders app\models\Order */
/* @var $product app\models\OrderDetail */

$this->title = '销售订单';

?>
<style media="screen">
  .addOrder{
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
    <h1>销售订单列表</h1>
    <table class="table table-striped table-hover1" id="product">
      <caption>销售订单</caption>
        <thead>
        <tr>
          <th>销售订单批次</th>
          <th>客户</th>
          <th>推荐人</th>
          <th>总价</th>
          <th>发票号</th>
          <th>销账状态</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $order): ?>
          <tr>
            <td id="<?= 'batch_'.$order['order']->order_id ?>"><?= $order['order']->order_batch;  ?></td>
            <td id="<?= 'client_'.$order['order']->order_id ?>"><?= $order['order']->getClient($order['order']->client_id)['client_name']; ?></td>
            <td id="<?= 'recommand_'.$order['order']->order_id ?>"><?= $order['order']->getclient($order['order']->client_recommand_id)['client_name']; ?></td>
            <td id="<?= 'total_'.$order['order']->order_id ?>"><?= $order['order']->order_total_money; ?></td>
            <td id="<?= 'billcode_'.$order['order']->order_id ?>"><?= $order['order']->order_bill_code; ?></td>
            <td id="<?= 'status_'.$order['order']->order_id ?>">
              <?php
                if ($order['order']->order_status == 0) {
                    echo '未销账';
                } elseif ($order['order']->order_status == 1) {
                    echo '已销账';
                }
              ?>
            </td>
          </tr>
            <?php endforeach; ?>
      </tbody>
    </table>
    <span>
      <a href="?r=site/addorder"><span class="btn btn-primary pull-right addOrder">增加销售订单</span></a>
    </span>
  </div>
</div>

<div class="col-lg-12">
      <table class="table table-striped" id="detail">
      <caption>销售订单明细</caption>
            <thead>
        <tr>
          <th>商品批次</th>
          <th>商品名称</th>
          <th>生产商</th>
          <th>通用名</th>
          <th>数量</th>
          <th>总价</th>
          <th>渠道成本</th>
          <th>利润</th>
          <th>专户结算总额</th>
        </tr>
      </thead>
      <tbody class="more-modal-body">
        
      </tbody>
    </table>
</div>

<script>
  document.getElementsByTagName('table')[0].onclick = function(ev) {
    var order_id = ev.target.id.split('_')[1];
    jQuery.ajax({
            url: "?r=site/orderdetail",
            method: 'POST',
            dataType: 'json',
            data: {
                function: true,
                order_id: order_id,
            },
            success: function(resp)
            {
              var orderDetailInfo = '';
              for(var key in resp) {
                orderDetailInfo = orderDetailInfo + 
                '<tr>'+
                  '<td>'+resp[key].product_batch+'</td>'+
                  '<td>'+resp[key].product_name+'</td>'+
                  '<td>'+resp[key].manufacture_name+'</td>'+
                  '<td>'+resp[key].product_chemical_name+'</td>'+
                  '<td>'+resp[key].product_num+'</td>'+
                  '<td>'+resp[key].order_detail_total_money+'</td>'+
                  '<td>'+resp[key].product_channel_cost+'</td>'+
                  '<td>'+resp[key].product_profit+'</td>'+
                  '<td>'+resp[key].total_accounts+'</td>'+
                '</tr>';
              }
              console.log(orderDetailInfo);
              $(".more-modal-body").html(orderDetailInfo);
            }
    });
  }
</script>

<script>
jQuery(document).ready(function($){
  oTable = $('#product').dataTable();
});
</script>
