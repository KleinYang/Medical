<?php

/* @var $this yii\web\View */
/* @var $manufacturers app\Models\manufacturer*/

use app\assets\AppAsset;

$this->title = '仓库';
?>
<style media="screen">
   .addRepository{
     margin: 10px;
   }
</style>
<div class="row">
  <div class="col-lg-10 col-lg-offset-1">
    <table class="table table-striped" id="product">
      <caption>仓库</caption>
      <thead>
        <tr>
          <th>仓库名称</th>
          <th>仓库地址</th>
          <th>联系人</th>
          <th>练习电话</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($repositories as $repository): ?>
          <tr>
            <td><?php echo $repository->repository_name; ?></td>
            <td><?php
              $repositoryAddress = $repository->getRepositoryAddress()->one();
              echo $repositoryAddress->getRegionProvince()->one()->region_name.
              $repositoryAddress->getRegionCity()->one()->region_name.
              $repositoryAddress->getRegionCountry()->one()->region_name.
              $repositoryAddress->repository_address; ?></td>
            <td><?php echo $repository->repository_contact_name; ?></td>
            <td><?php echo $repository->repository_contact_call; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <a href="?r=site/addrepository"><span class="btn btn-primary pull-right addRepository">添加仓库</span></a>
  </div>
</div>
<?php AppAsset::addJsFile($this, '/js/jquery.dataTables.min.js'); ?>
<?php AppAsset::addJsFile($this, '/js/index.js'); ?>
