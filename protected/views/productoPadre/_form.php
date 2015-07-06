<?php
/* @var $this ProductoPadreController */
/* @var $model ProductoPadre */
/* @var $form CActiveForm */
?>

<div class="row-fluid">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array( 
	'id'=>'producto-padre-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'type'=>'horizontal',
	'clientOptions'=>array(
		'validateOnSubmit'=>true, 
	),
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
));?>
</div>

	<div class="col-md-6 col-md-offset-3 margin_top_small">
	<?php echo $form->textFieldRow($model,'nombre',array('id'=>'nombre','class'=>'form-control')); ?>
	<?php echo $form->error($model,'nombre'); ?>
	</div>
	
		<div class="col-md-6 col-md-offset-3 margin_top_small">
		<?php echo $form->labelEx($model,'id_marca'); ?> 
		<?php echo $form->dropDownList($model,'id_marca', CHtml::listData(Marca::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'),array('id'=>'id_marca','class'=>'form-control','empty'=>'Seleccione una marca')); ?>
		<?php echo $form->error($model,'id_marca'); ?>
	</div>

	
	<div id="principale" class="col-md-6 col-md-offset-3 margin_top" class="btn btn-danger form-control">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
			'htmlOptions'=>array('class'=>'form-control')
		)); ?>

	</div> 
	
	<div id="avanzar" class="col-md-6 col-md-offset-3 margin_top">
			<a class="btn btn-danger form-control"  title="Guardar">Guardar</a>
	</div>
	
<?php $this->endWidget(); ?>

<script>
$(document).ready(function() {
	
	
	$('#principale').hide();
	var idAct="<?php echo($model->id);?>";
	
	$('#avanzar').on('click', function(event) {
		event.preventDefault();
		var marca=$('#id_marca').val();
		var nombre=$('#nombre').val().toLowerCase();// colocar todo en minusculas
		nombre=nombre.charAt(0).toUpperCase() + nombre.slice(1); // poner la primera letra en mayusculas
		if(nombre=="" || marca=="")
		{
			alert('nombre ni marca pueden ser vacios');
			return false;
		}
		else
		{ 
				$.ajax({
		         url: "<?php echo Yii::app()->createUrl('productoPadre/busqueda') ?>",
	             type: 'POST',
		         data:{
	                    nombre:nombre, idAct:idAct, marca:marca
	                   },
		        success: function (data) {
					
					if(data==0)
					{
						alert('Nombre ya existente');
						return false;
					}
					else
					{
						window.location.href = '../admin/';
					}
		       	}
		       })
			
		}
		

	});

});		
</script>