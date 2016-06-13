<?php
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;

	$this->title = '销售发票号与批次不全';
?>
<style>
	
</style>

<div class="row">
	<div class="col-lg-12">
		<h1>销售发票号与批次不全</h1>
		<?php $form = ActiveForm::begin([
			'id' => 'not-bill-form',
			'options' => ['class' => 'form-horizontal'],
		]); ?>
		<table class="table table-striped" id="product">
			<thead>
				<tr>
					<th>销售订单批次</th>
					<th>客户</th>
					<th>推荐人</th>
					<th>总价</th>
					<th>发票号</th>
					<th>订单开始时间</th>
					<th>订单状态</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($order as $v) : ?>
				<tr>
					<?php //var_dump($v);exit(); ?>
					<?php if(($v->order_bill_code==null)||($v->order_batch==null)): ?>
					<td><?= $v->order_batch; ?></td>
					<td><?= $v->getClient($v->client_id)['client_name']; ?></td>
					<td><?= $v->getClient($v->client_recommand_id)['client_name']; ?></td>
					<td><?= $v->order_total_money; ?></td>
					<!-- <td> $v->order_bill_code; ></td> -->
					<td><?= $form->field($model, 'orderBillCode[]')->textInput(array('class' => 'col-lg-6 col-lg-offset-0', 'value' => $v->order_bill_code))->label('') ?>
						<?= $form->field($model, 'orderId[]')->textInput(['class' => 'col-lg-1 col-lg-offset-0', 'label' => '', 'value' => $v->order_id, 'type' => 'hidden'])->label(''); ?>
					</td>
					<td><?= $v->order_create_timestamps; ?></td>
					<td>
						<?php if(!$v->order_settlement_status) {
							echo '已销账未结算';
						} else {
							echo '已销账已结算';
						} ?>
					</td>
				</tr>
				<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
		<div class="form-group">
			<?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
		</div>
	<?php ActiveForm::end(); ?>
	</div>
</div>


