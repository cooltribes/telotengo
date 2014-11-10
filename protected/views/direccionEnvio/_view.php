<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telefono')); ?>:</b>
	<?php echo CHtml::encode($data->telefono); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('direccion_1')); ?>:</b>
	<?php echo CHtml::encode($data->direccion_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('direccion_2')); ?>:</b>
	<?php echo CHtml::encode($data->direccion_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ciudad_id')); ?>:</b>
	<?php echo CHtml::encode($data->ciudad_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('provincia_id')); ?>:</b>
	<?php echo CHtml::encode($data->provincia_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('users_id')); ?>:</b>
	<?php echo CHtml::encode($data->users_id); ?>
	<br />


</div>