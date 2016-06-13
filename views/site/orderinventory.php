<?php
use yii\widgets\ActiveForm;
use app\assets\AppAsset;
use yii\helpers\Html;

$this->title = '采购库存';
?>
<style media="screen">
   .addProduct{
     margin: 10px;
   }
</style>
<h1>采购库存</h1>
<div class="row">
  <div class="col-lg-12">
      <caption>商品目录</caption>
      <table class="table table-striped" id="product">
        <thead>
          <tr>
            <th>批次</th>
            <th>商品名称</th>
            <th>商品别名</th>
            <th>生产厂商</th>
            <th>数量</th>
            <th>价格</th>
            <th>剩余</th>
          </tr>
        </thead>
        <tbody>
          <?php  foreach ($products as $v): ?>
          <?php $details = $v['detail']; ?>
          <?php foreach ($details as $product): ?>
            <tr>
              <td><?php echo $v['order']->purchase_batch ?></td>
              <td><?php echo $product->getProduct($product->product_id)['product_name']; ?></td>
              <td><?php echo $product->getProduct($product->product_id)['product_chemical_name']; ?></td>
              <td><?php echo $product->getManufacturerByProduct($product->product_id)['client_name']; ?></td>
              <td><?php echo $product->product_num; ?></td>
              <td><?= $product->price; ?></td>
              <td><?= $product->product_residue_num; ?></td>
            </tr>
          <?php endforeach; ?>
          <?php endforeach; ?>
        </tbody>
      </table>
  </div>
</div>

<script>
jQuery(document).ready(function($){
  oTable = $('#product').dataTable();
});
</script>
