<?php
/* @var $this AtributoController */
/* @var $data Atributo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_unidad')); ?>:</b>
	<?php echo CHtml::encode($data->tipo_unidad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo')); ?>:</b>
	<?php echo CHtml::encode($data->tipo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('multiple')); ?>:</b>
	<?php echo CHtml::encode($data->multiple); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rango')); ?>:</b>
	<?php echo CHtml::encode($data->rango); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('obligatorio')); ?>:</b>
	<?php echo CHtml::encode($data->obligatorio); ?>
	<br />


</div>