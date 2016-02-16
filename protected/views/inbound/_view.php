<?php
/* @var $this InboundController */
/* @var $data Inbound */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_carga')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_carga); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_productos')); ?>:</b>
	<?php echo CHtml::encode($data->total_productos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_cantidad')); ?>:</b>
	<?php echo CHtml::encode($data->total_cantidad); ?>
	<br />


</div>