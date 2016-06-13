<?php

/* @var $this yii\web\View */

use app\assets\AppAsset;

$this->title = '医疗销售系统';

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

</style>
<div class="row">
  <div class="col-lg-12">
    <h1>产品目录</h1>
    <div class="table-responsive">
    <table class="table table-striped table-hover1" cellspacing="0" width="100%" id="product">
      <caption>商品目录</caption>
      <thead>
        <tr>
          <th>产品名称</th>
          <th>通用名</th>
          <th>生产厂家</th>
          <th>供应商</th>
          <th>渠道商</th>
          <th>规格</th>
          <th>保质期</th>
          <th>采购价</th>
          <th>含税采购价</th>
          <th>零售价</th>
          <th>含税零售价</th>
          <th>批发价</th>
          <th>含税批发价</th>
          <th>附件</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $product): ?>
          <tr>
            <td><?php echo $product->product_name; ?></td>
            <td><?php echo $product->product_chemical_name; ?></td>
            <td><?php echo $product->getManufacturer($product->client_manufacture_id)['client_name']; ?></td>
            <td><?php echo $product->getManufacturer($product->client_supplier_id)['client_name']; ?></td>
            <td><?php echo $product->getManufacturer($product->client_channel_id)['client_name']; ?></td>
            <td><?php echo $product->product_specification; ?></td>
            <td><?php echo $product->product_validity; ?></td>
            <td><?php echo $product->purchase_price; ?></td>
            <td><?php echo $product->purchase_unit_price; ?></td>
            <td><?php echo $product->retail_price; ?></td>
            <td><?php echo $product->retail_unit_price; ?></td>
            <td><?php echo $product->trade_price; ?></td>
            <td><?php echo $product->trade_unit_price; ?></td>
            <td><a href="<?= $product->file?>" target="_blank">下载</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
    <span>
      <a href="?r=site/addproduct"><span class="btn btn-primary pull-right addProduct">添加产品</span></a>
    </span>
  </div>
</div>


<?php AppAsset::addJsFile($this, '/js/index.js'); ?>
<script>
jQuery(document).ready(function($){
  oTable = $('#product').dataTable();
});
</script>
