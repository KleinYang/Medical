<?php
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	$this->title = '采购发票号与批次不全';
?>
<style>
	
</style>

<div class="row">
	<div class="col-lg-12">
		<h1>采购发票号与批次不全</h1>
		<?php $form = ActiveForm::begin([
			'id' => 'not-bill-form',
			'options' => ['class' => 'form-horizontal'],
		]); ?>
		<table class="table table-striped" id="product">
			<thead>
				<tr>
					<th>采购订单批次</th>
					<th>联系人</th>
					<th>联系人电话</th>
					<th>总价</th>
					<th>发票号</th>
					<th>订单开始时间</th>
					<th>订单状态</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($purchase as $v) : ?>
				<tr>
					<?php //var_dump($v);exit(); ?>
					<?php if(($v->purchase_bill_code==null)||($v->purchase_batch==null)): ?>
					<td><?= $v->purchase_batch; ?></td>
					<td><?= $v->purchase_contact_name; ?></td>
					<td><?= $v->purchase_contact_call; ?></td>
					<td><?= $v->purchase_total_money; ?></td>
					<td><?= $form->field($model, 'purchaseBillCode[]')->textInput(array('class' => 'col-lg-6 col-lg-offset-0', 'value' => $v->purchase_bill_code))->label('') ?>
						<?= $form->field($model, 'purchaseId[]')->textInput(['class' => 'col-lg-1 col-lg-offset-0', 'label' => '', 'value' => $v->purchase_id, 'type' => 'hidden'])->label(''); ?>
					</td>
					<td><?= $v->purchase_create_timestamps; ?></td>
					<td>
						<?php if(!$v->purchase_status) {
							echo '尚未支付';
						} else {
							echo '已支付';
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

