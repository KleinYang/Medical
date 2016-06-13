<?php
	$this->title = '采购尚未付款';
?>
<style>
	
</style>

<div class="row">
	<div class="col-lg-12">
		<h1>采购尚未付款</h1>
		<table class="table table-striped"  id="product">
			<thead>
				<tr>
					<th>销售订单批次</th>
					<th>联系人</th>
					<th>联系人电话</th>
					<th>总价</th>
					<th>发票号</th>
					<th>订单开始时间</th>
					<th>订单状态</th>
					<th>操作</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($purchase as $v) : ?>
				<tr>
					<?php if($v->purchase_status==0): ?>
					<td><?= $v->purchase_batch; ?></td>
					<td><?= $v->purchase_contact_name; ?></td>
					<td><?= $v->purchase_contact_call; ?></td>
					<td><?= $v->purchase_total_money; ?></td>
					<td><?= $v->purchase_bill_code; ?></td>
					<td><?= $v->purchase_create_timestamps; ?></td>
					<td>
						<?php if(!$v->purchase_status) {
							echo '尚未支付';
						} else {
							echo '已支付';
						} ?>
					</td>
					<td><a href="?r=site/notpay" onclick='writeoff(<?= $v->purchase_id ?>)'>结算</a></td>
				</tr>
				<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<script>
	function writeoff(purchase_id) {
		jQuery.ajax({
			url: "?r=site/pay",
			method: "POST",
			dataType: 'json',
			data: {
				function: true,
				purchase_id: purchase_id,
			},
		});
		document.execCommand('Refresh');
	}
</script>


