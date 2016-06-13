<?php

/* @var $this yii\web\View */
/* @var $manufacturers app\Models\manufacturer*/

use app\assets\AppAsset;

$this->title = '厂商';
?>
<style media="screen">
   .addManufacturer{
     margin: 10px;
   }
</style>
<div class="row">
  <div class="col-lg-10 col-lg-offset-1">
    <table class="table table-striped" id="product">
      <caption>生产厂商</caption>
      <thead>
        <tr>
          <th>厂家名称</th>
          <th>厂家别名</th>
          <th>地址</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($manufacturers as $manufacturer): ?>
          <tr>
            <td><?php echo $manufacturer->manufacturer_name; ?></td>
            <td><?php echo $manufacturer->manufacturer_alias; ?></td>
            <td><?php
              $manufacturerAddress = $manufacturer->getManufacturerAddress()->one();
              echo $manufacturerAddress->getRegionProvince()->one()->region_name.
              $manufacturerAddress->getRegionCity()->one()->region_name.
              $manufacturerAddress->getRegionCountry()->one()->region_name.
              $manufacturerAddress->manufacturer_address;
             ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <a href="?r=site/addmanufacturer"><span class="btn btn-primary pull-right addManufacturer">添加厂家</span></a>
  </div>
</div>
<?php AppAsset::addJsFile($this, '/js/jquery.dataTables.min.js'); ?>
<?php AppAsset::addJsFile($this, '/js/index.js'); ?>
