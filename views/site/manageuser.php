<?php
/* @var $this yii\web\View */
/* @var $clients app\Models\manufacturer*/
use app\assets\AppAsset;

?>
<style media="screen">
.modal-backdrop {
    display: none;
   }
</style>
<div class="row">
    <div class="col-lg-10">
    	<h1>客户列表</h1>
    	<div class="panel-body">
			<table id="example" class="table table-striped table-bordered table-hover1" cellspacing="0" width="100%">
			</table>
		</div>
	</div>
</div>

<div class="modal fade" id="myModal" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">用户登陆信息</h4>
			</div>
			
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">							
						<div class="form-group">
							<label for="field-1" class="control-label">用户名</label>								
							<input type="text" class="form-control" id="username" placeholder="用户名">
						</div>								
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">							
						<div class="form-group">
							<label for="field-5" class="control-label">密码</label>								
							<input type="password" class="form-control" id="password" placeholder="密码">
						</div>							
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">							
						<div class="form-group">
							<label for="field-5" class="control-label">手机号</label>								
							<input type="tel" class="form-control" id="tel" placeholder="手机号">
						</div>							
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">							
						<div class="form-group">
							<label>选择地址</label>
							<select name="regionProvince" class='form-control' id='regionProvince'>
								<option value="0" selected="selected">请选择省份</option>
								<?php foreach ($regionProvinces as $key=>$v): ?>
								<?php echo "<option value=".$v['id'].">".$v['region_name']."</option>";?>
								<?php endforeach; ?>
							</select>
						</div>							
					</div>
					<div class="col-md-4">							
						<div class="form-group">
							<br />
							<select name="regionCity" class='form-control' id='regionCity'>
								<option value="0" selected="selected">请选择城市</option>
							</select>
						</div>							
					</div>
					<div class="col-md-4">							
						<div class="form-group">
							<br />
							<select name="regionCountry" class='form-control' id='regionCountry'>
								<option value="0" selected="selected">请选择村/区</option>
							</select>
						</div>							
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">							
						<div class="form-group">
							<label for="field-5" class="control-label">详细地址</label>								
							<input type="text" class="form-control" id="detailAddress" placeholder="详细地址">
						</div>							
					</div>
				</div>
			</div>
			
			<div class="modal-footer">
				<button class="btn btn btn-info" id="btnSave">确定</button>
				<button class="btn btn btn-info" id="btnEdit">保存</button>
				<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">取消</button>     
			</div>
		</div>
	</div>
</div>

<script>
	var oTable;
	jQuery(document).ready(function($){
		$("#btnSave").click(_addFun);
		$("#regionProvince").bind('change', function() {
			getReion($(this).val(),"#regionCity");
		});
		$("#regionCity").bind('click',function (){
			getReion($(this).val(),"#regionCountry");
		});
		oTable = $("#example").dataTable({
			'paginate': true,
		    "destory": true,
		    "retrieve": true,
		    "processing": true,
			"dom": "<'row'<'col-sm-6 myBtnBox'><'col-sm-6'f>r>"+"t"+"<'row'<'col-xs-6'i>>",// 布局
			"ajax": {
			    "url":"?r=site/userlist",
			    "type":"post",
			    "data": function () {
				},
			},
			"ordering":false,
			"columns": [
				{ "data": "username" , "title":"用户名"},
				{ "data": "tel" , "title":"手机号"},
				{ "data": "user_type" , "title":"用户类型"},
				{ "data": "address" , "title":"用户地址"},
				{ "data": "id" , "title":"用户操作",
				"createdCell": function (td, cellData, rowData, row, col) {
				    $(td).html("<a href='javascript:void(0);'" +
                	"onclick='_delFun("+cellData+");'>删除</a>");
				    }
				},
            ],
            
  			"initComplete": function (oSettings, json) {
             	$('<a href="javascript:void(0);"'+"onclick='_init();'"+ ' id="addFun" class="btn btn-primary" data-toggle="modal">新增</a>' + '&nbsp;'
             ).appendTo($('.myBtnBox'));
            }
		});
	});

	function _init() {
		$("#myModal").modal("show");
		$("#btnEdit").hide();
		$("#btnSave").show();
	}

	function _addFun() {
		$.ajax({
		    url: "?r=site/useradd",
		    data: {
				username:$('#username').val(),
				password:$('#password').val(),
				tel:$('#tel').val(),
				regionProvince:$('#regionProvince').val(),
				regionCity:$('#regionCity').val(),
				regionCountry:$('#regionCountry').val(),
				detailAddress:$('#detailAddress').val(),
				},
		    type: "post",
		    success: function (resp) {
		        $("#myModal").modal("hide");
		        oTable.api().ajax.reload();
		    }, error: function (error) {
		        console.log(error);
		    }
		});
	}

	function _delFun(id) {
		if(confirm('确认删除？')) {
			$.ajax({
			    url: "?r=site/userdel",
			    data: { id: id, },
			    type: "post",
			    success: function (resp) {
			    	console.log(resp);
			        oTable.api().ajax.reload();
			    }, error: function (error) {
			        console.log(error);
			    }
			});
		}
	}

	function getReion(parentId,tag){
		$.ajax({
			url: "?r=site/getregion",
			type: 'POST',
			dataType: 'json',
			data: {
			parentId: parentId
		},
		success: function(data, status) {
			$(tag).html("");
			$.each(data, function(index, address) {
			$(tag).append("<option value=" + address['id'] + ">" + address['name'] + "</option>");
			});
		}
		});
	}
</script>