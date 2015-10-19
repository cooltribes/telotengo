<div class="well">
	<div class="row padding_left_small">
		<div class="col-md-6 1">


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'almacen-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'provincia_id', array('class'=>'col-sm-2')); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'provincia_id', CHtml::listData(Provincia::model()->findAll(array('order' => 'nombre')),'id', 'nombre'), array('empty' => 'Seleccione...', 'class' => 'form-control')); ?>
        </div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'ciudad_id', array('class'=>'col-sm-2')); ?>
		<div class="col-sm-10">
			<?php 
			if(Yii::app()->controller->action->id == 'update'){
				echo $form->dropDownList($model, 'ciudad_id', CHtml::listData(Ciudad::model()->findAllByAttributes(array('provincia_id'=>$model->provincia_id), array('order' => 'nombre')),'id', 'nombre'), array('empty' => 'Seleccione un estado...', 'class' => 'form-control')); 
			}else{
				echo $form->dropDownList($model, 'ciudad_id', array(), array('empty' => 'Seleccione un estado...', 'class' => 'form-control')); 
			}
			?>
        </div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'ubicacion', array('class'=>'col-sm-2')); ?>
		<div class="col-sm-10">
			<?php echo $form->textArea($model,'ubicacion',array('size'=>60,'maxlength'=>245,'class'=>'form-control')); ?>
		</div>
		<?php echo $form->error($model,'ubicacion'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'alias', array('class'=>'col-sm-2')); ?>
		<div class="col-sm-10">
			<?php echo $form->textField($model,'alias',array('class'=>'form-control')); ?>
		</div>
		<?php echo $form->error($model,'alias'); ?>
	</div>
	
	<div class="form-group">
		<?php echo $form->labelEx($model,'nombre', array('class'=>'col-sm-2')); ?>
		<div class="col-sm-10">
			<?php echo $form->textField($model,'nombre',array('class'=>'form-control')); ?>
		</div>
		<?php echo $form->error($model,'nombre'); ?>
	</div>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Registrar' : 'Guardar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

	</div>
	</div>
	</div>
<script>
	/*$(document).ready(function(){
		if($('#Almacen_provincia_id').val() != ''){
			var path = location.pathname.split('/');
			$.ajax({
			      url: "<?php echo Yii::app()->createUrl('direccionEnvio/cargarCiudades'); ?>",
			      type: "post",
			      data: { provincia_id : $('#Almacen_provincia_id').val() },
			      success: function(data){
			           $('#Almacen_ciudad_id').html(data);
			           //$("#Almacen_ciudad_id option[value='"+$('#Almacen_ciudad_id').val()+"']").attr("selected", "selected");
			           console.log($('#Almacen_ciudad_id').val());
			      },
			});
		}
	});*/

	$('#Almacen_provincia_id').change(function(){
		if($(this).val() != ''){
			var path = location.pathname.split('/');
			$.ajax({
			      url: "<?php echo Yii::app()->createUrl('direccionEnvio/cargarCiudades'); ?>",
			      type: "post",
			      data: { provincia_id : $(this).val() },
			      success: function(data){
			           $('#Almacen_ciudad_id').html(data);
			      },
			});
		}
	});
	
</script>