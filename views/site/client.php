<?php

/* @var $this yii\web\View */
/* @var $clients app\Models\manufacturer*/

use app\assets\AppAsset;

$this->title = '厂商';
$level = array('无', '甲', '乙', '丙');
$grade = array('无', '一', '二', '三');
?>
<style media="screen">
   .addClient{
     margin: 10px;
   }
   .modal-backdrop {
    display: none;
   }

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
    <h1>客户列表</h1>
    <table class="table table-striped table-hover1" id="product">
      <caption>客户</caption>
      <thead>
        <tr>
          <th>名称</th>
          <th>联系人</th>
          <th>地址</th>
          <th>客户类型</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($clients as $client): ?>
          <tr>
            <td class="client_detail"><a href="javascript:;" id="<?= $client->client_id; ?>" >
              <?= $client->client_name; ?></a></td>
            <td ><?= $client->client_contact ?></td>
            <td><?php
              $clientAddress = $client->getClientAddress()->one();
              echo $clientAddress->getRegionProvince()->one()->region_name.
              $clientAddress->getRegionCity()->one()->region_name.
              $clientAddress->getRegionCountry()->one()->region_name.
              $clientAddress->client_address;
             ?></td>
             <td>
              <?= $client->client_type;?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <a href="?r=site/addclient"><span class="btn btn-primary pull-right addManufacturer">添加用户</span></a>
  </div>
</div>

<div class="modal fade" id="moreInfo" tabindex="-1" role="dialog"
       aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="profile-info-row">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
           
              <h4 class="modal-title" id="myModalLabel"> 客户详情 </h4>
            </div>
            <div class="more-modal-body">
            </div>
            <div class="modal-footer"> 
              <button type="button" class="btn btn-default"
                  data-dismiss="modal">
                关闭
              </button>
            </div>
          </div>
        </div>
      </div>

<script>

document.getElementById('product').onclick = function(ev) {
  //alert(ev);
  if(ev.target.id) {
    jQuery.ajax({
            url: "?r=site/print",
            method: 'POST',
            dataType: 'json',
            data: {
                function: true,
                client_id: ev.target.id,
            },
            success: function(resp)
            {
              console.log(resp);

              var userInfo = '<form role="form" class="form-horizontal" >'+
                    '<div class="form-group">'+
                        '<label class="col-sm-2 control-label" for="product_name" >用户名</label>'+
                        '<div class="col-sm-10" style="max-width:450px">'+
                            '<input class="form-control" name="product_name" id="product_name" type="text"'+
                                   'placeholder=""'+
                                   'value='+ resp.client_name +'>'+
                        '</div>'+
                   ' </div>'+


                    '<div class="form-group">'+
                        '<label class="col-sm-2 control-label" for="product_chemical_name" >别名</label>'+
                        '<div class="col-sm-10" style="max-width:450px">'+
                            '<input class="form-control" name="product_chemical_name" id="product_chemical_name" type="text"'+
                                   'placeholder=""'+
                                   'value='+resp.client_alias +'>'+
                        '</div>'+
                    '</div>'+

                    '<div class="form-group">'+
                        '<label class="col-sm-2 control-label" for="product_batch" >联系人</label>'+
                        '<div class="col-sm-10" style="max-width:450px">'+
                            '<input class="form-control" name="product_batch" id="product_batch" type="text"'+
                                   'placeholder=""'+
                                   'value='+resp.client_contact+'>'+
                        '</div>'+
                    '</div>'+

                    '<div class="form-group">'+
                        '<label class="col-sm-2 control-label" for="product_specification" >用户类型</label>'+
                        '<div class="col-sm-10" style="max-width:450px">'+
                            '<input class="form-control" name="product_specification" id="product_specification" type="text"'+
                                   'placeholder=""'+
                                   'value='+ resp.client_type + '>'+
                        '</div>'+
                    '</div>'+

                    '<div class="form-group">'+
                        '<label class="col-sm-2 control-label" for="product_num" >电话</label>'+
                        '<div class="col-sm-10" style="max-width:450px">'+
                            '<input class="form-control" name="product_num" id="product_num" type="text"'+
                                   'placeholder=""'+
                                   'value='+resp.client_tel+'>'+
                        '</div>'+
                    '</div>'+
     
                    '<div class="form-group">'+
                        '<label class="col-sm-2 control-label" for="product_default_price" >邮箱</label>'+
                        '<div class="col-sm-10" style="max-width:450px">'+
                            '<input class="form-control" name="product_default_price" id="product_default_price" type="text"'+
                                   'placeholder=""'+
                                   'value='+resp.client_email +'>'+
                        '</div>'+
                    '</div>'+
                    
                    '<div class="form-group">'+
                        '<label class="col-sm-2 control-label" for="client_manufacture_id" >银行账号</label>'+
                        '<div class="col-sm-10" style="max-width:450px">'+
                            '<input class="form-control" name="client_manufacture_id" id="client_manufacture_id" type="text"'+
                                   'placeholder=""'+
                                   'value='+ resp.client_bank_account +'>'+
                        '</div>'+
                    '</div>'+

                    '<div class="form-group">'+
                        '<label class="col-sm-2 control-label" for="client_supplier_id">工商信息</label>'+
                        '<div class="col-sm-10" style="max-width:450px">'+
                            '<input class="form-control" name="client_supplier_id" id="client_supplier_id" type="text"'+
                                   'value='+resp.client_bussiness_info+ '>'+
                       ' </div>'+
                    '</div>'+

                    '<div class="form-group">'+
                        '<label class="col-sm-2 control-label" for="client_channel_id">等级</label>'+
                        '<div class="col-sm-10" style="max-width:450px">'+
                            '<input class="form-control" name="client_channel_id" id="client_channel_id" type="text"'+
                                   'value='+ resp.client_level +'>'+
                        '</div>'+
                    '</div>'+
                    
                    '<div class="form-group">'+
                        '<label class="col-sm-2 control-label" for="product_validity">级别</label>'+
                        '<div class="col-sm-10" style="max-width:450px">'+
                            '<input class="form-control" name="product_validity" id="product_validity" type="text"'+
                                   'value='+resp.client_grade+'>'+
                        '</div>'+
                    '</div>'+

                    '<div class="form-group">'+
                        '<label class="col-sm-2 control-label" for="product_validity">备注</label>'+
                        '<div class="col-sm-10" style="max-width:450px">'+
                            '<input class="form-control" name="product_validity" id="product_validity" type="text"'+
                                   'value='+resp.client_memo+'>'+
                        '</div>'+
                    '</div>'+
                '</form>';
            $(".more-modal-body").html(userInfo);
            //$('.more-modal-body').prepend(userInfo);
            jQuery('#moreInfo').modal('show', {backdrop: 'static'});
            }
        });

    }
  }

</script>


}
<script>
jQuery(document).ready(function($){
  oTable = $('#product').dataTable();
});
</script>


