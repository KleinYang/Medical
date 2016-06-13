<?php

/* @var $this yii\web\View */
/* @var $orders app\models\Order */
/* @var $product app\models\OrderDetail */

$this->title = '调度报表';
?>
<style media="screen">
  .dispatchlist{
    margin: 10px;
  }
  #detail {
      white-space:nowrap;
   }
</style>
<div class="row">
  <div class="col-lg-12">
    <h1>调度订单列表</h1>
    <table class="table table-striped table-hover1" id="product">
      <caption>调度订单</caption>
        <thead>
        <tr>
          <th>调度订单批次</th>
          <th>客户</th>
          <th>总价</th>
          <th>发票号</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($dispatchs as $order): ?>
          <tr>
            <td id="<?= 'batch_'.$order->order_id ?>"><?= $order->order_batch;  ?></td>
            <td id="<?= 'client_'.$order->order_id ?>"><?= $order->getClient($order->client_id)['client_name']; ?></td>
            <td id="<?= 'total_'.$order->order_id ?>"><?= $order->order_total_money; ?></td>
            <td id="<?= 'billcode_'.$order->order_id ?>"><?= $order->order_bill_code; ?></td>
            <!-- <td id="<?= 'status_'.$order->order_id ?>">
              <?php
                if ($order->order_status == 0) {
                    echo '未销账';
                } elseif ($order->order_status == 1) {
                    echo '已销账';
                }
              ?>
            </td> -->
          </tr>
            <?php endforeach; ?>
      </tbody>
    </table>
    <!-- <span>
      <a href="?r=site/adddispatch"><span class="btn btn-primary pull-right addOrder">增加调度订单</span></a>
    </span> -->
  </div>
</div>
<!-- 
<script>
jQuery(document).ready(function($){
  oTable = $('#product').dataTable();
});
</script> -->