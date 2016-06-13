<?php
	$this->title = '销售已到账未结算';
?>
<style>
	
</style>

<div class="row">
	<div class="col-lg-12">
		<h1>销售已到账未结算</h1>
		<table class="table table-striped" id="product">
			<thead>
				<tr>
					<th>销售订单批次</th>
					<th>客户</th>
					<th>推荐人</th>
					<th>总价</th>
					<th>订单开始时间</th>
					<th>订单状态</th>
					<th>操作</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($order as $v) : ?>
				<tr>
					<?php if(($v->order_status==1)&&($v->order_settlement_status==0)): ?>
					<td><?= $v->order_batch; ?></td>
					<td><?= $v->getClient($v->client_id)['client_name']; ?></td>
					<td><?= $v->getClient($v->client_recommand_id)['client_name']; ?></td>
					<td><?= $v->order_total_money; ?></td>
					<td><?= $v->order_create_timestamps; ?></td>
					<td>
						<?php if(!$v->order_settlement_status) {
							echo '已销账未结算';
						} else {
							echo '已销账已结算';
						} ?>
					</td>
					<td><a href="?r=site/notsettlement" onclick='writeoff(<?= $v->order_id ?>)'>结算</a></td>
				</tr>
				<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

<script>
	function writeoff(order_id) {
		jQuery.ajax({
			url: "?r=site/settlement",
			method: "POST",
			dataType: 'json',
			data: {
				function: true,
				order_id: order_id,
			},
		});
		document.execCommand('Refresh');
	}
</script>


