<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url_amigable')); ?>:</b>
	<?php echo CHtml::encode($data->url_amigable); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('imagen_url')); ?>:</b>
	<?php echo CHtml::encode($data->imagen_url); ?>
	<br />


</div>