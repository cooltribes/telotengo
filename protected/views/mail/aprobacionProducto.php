<div style="font-size: 14px;">
    <div style=" margin-top: 15px; font-size: 14px;">Estimado <?php echo $user->profile->first_name." ".$user->profile->last_name; ?>,
    </div>

    <div style=" margin-top: 4px;">
    <p>
    <?php if($aprobar==1){?>
    Te informamos que el nuevo producto que solicitaste ha sido aprobado exitosamente.
    <?php }else{?>
    	Te informamos que el producto que solicitaste ha sido rechazado.
    <?php }?>
    </p>

    <b>Nombre:</b> <?php echo $model->nombre;?><br>
	<b>Marca:</b>  <?php echo $model->padre->idMarca->nombre;?><br>
	<b>Modelo:</b> <?php echo $model->modelo;?><br>
	<b>Categoría:</b> <?php echo Categoria::model()->findByPk($model->padre->idCategoria->getCategoriaOrigen($model->padre->idCategoria->id))->nombre;?><br>
	<b>Subcategoría:</b> <?php echo $model->padre->idCategoria->nombre;?><br>
	<?php if($model->upc!=""):?>
		<b>UPC:</b> <?php echo $model->upc;?><br>
	<?php endif;?>
	<?php if($model->nparte!=""):?>
		<b>Número de parte del Fabricante:</b> <?php echo $model->nparte;?><br>
	<?php endif;?>
	<b>Color:</b> <?php echo $model->colore->nombre;?><br><br>

	 <?php if($aprobar==1){?>
	Para proceder a indicar la cantidad que deseas vender dirígete al menú Inventario y selecciona la opción <a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'].Yii::app()->createUrl('producto/seleccion');?>">Cargar</a><br><br>
	<?php }else{?>
		Las razón por la que rechazamos la creación de algunos productos es porque no cumplen con los parámetros establecidos o ya se encuentran registrados en nuestro sistema. Si deseas solicitar otro producto dirígete al menú Inventario y selecciona la opción <a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'].Yii::app()->createUrl('producto/nuevoProducto');?>">Agregar nuevo producto</a><br><br>
		<?php }?>
	 <?php if($aprobar==1){?>
	¡Gracias por vender en Telotengo!
	<?php }else{?>
	¡Gracias por participar en Telotengo!
	<?php }?>						                       
    </div>


</div>