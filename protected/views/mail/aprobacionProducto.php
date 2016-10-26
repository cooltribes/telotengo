<div style="font-size: 14px;">
    <div style=" margin-top: 15px; font-size: 14px;">Estimado <?php echo $user->profile->first_name." ".$user->profile->last_name; ?>,
    </div>

    <div style=" margin-top: 4px;">
    <p>
    <?php if($aprobar==1){?>
    Te informamos que el nuevo producto que solicitaste ha sido creado exitosamente.
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
	 
	 <form action="<?php echo 'http://' . $_SERVER['HTTP_HOST'].Yii::app()->createUrl('producto/seleccion');?>">
	    <input   type="submit" value="Cargar Inventario" style="
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: normal;
    line-height: 1.428571429;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    cursor: pointer;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    -o-user-select: none;
    user-select: none;
    background-color: #ff5b0b;
    height: 34px;
    border: solid 1px #FFF;
    font-weight: 600;
    border-radius: 0;
    color: #fff;
    margin-left: 41.6%;
"/>
	</form>
     
	 <hr>
				<p>Si el producto creado no coincide con el que deseabas, ingresa al formulario de <a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'].Yii::app()->createUrl('site/contactanos');?>">Contacto</a> selecciona el motivo <b>Dudas acerca de productos</b> y en el campo <b>Mensaje*</b> indícanos las diferencias y con mucho gusto lo modificaremos o crearemos justo el que necesitas.</p>
	<?php }else{?>
		Las razón por la que rechazamos la creación de algunos productos es porque no cumplen con los parámetros establecidos o ya se encuentran registrados en nuestro sistema. Si deseas solicitar otro producto dirígete al menú Inventario y selecciona la opción <a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'].Yii::app()->createUrl('producto/nuevoProducto');?>">Agregar nuevo producto</a><br><br>
		<?php }?>
	 <?php if($aprobar==0){?>
	 		¡Gracias por participar en Telotengo!
	<?php } ?>

						                       
    </div>


</div>