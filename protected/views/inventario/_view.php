<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('precio')); ?>:</b>
	<?php echo CHtml::encode($data->precio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cantidad')); ?>:</b>
	<?php echo CHtml::encode($data->cantidad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('almacen_id')); ?>:</b>
	<?php echo CHtml::encode($data->almacen_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('producto_id')); ?>:</b>
	<?php echo CHtml::encode($data->producto_id); ?>
	<br />


</div>