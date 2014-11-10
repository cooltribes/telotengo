<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'direccion-facturacion-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'type'=>'horizontal',
	'clientOptions'=>array(
		'validateOnSubmit'=>true, 
	),
	'htmlOptions'=>array('class'=>'form-horizontal','role'=>"form"),
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<div class="form-group"> 
		<?php echo $form->textFieldRow($model,'direccion_1',array('class'=>'form-control','maxlength'=>255)); ?>
	</div>
	<div class="form-group"> 
		<?php echo $form->textFieldRow($model,'direccion_2',array('class'=>'form-control','maxlength'=>255)); ?>
	</div>
	<div class="form-group"> 
		<?php echo $form->textFieldRow($model,'telefono',array('class'=>'form-control','maxlength'=>50)); ?>
	</div>
	<div class="form-group"> 
		<div class="controls">
        	<?php echo $form->dropDownListRow($model,'provincia_id', CHtml::listData(Provincia::model()->findAll(array('order' => 'nombre')),'id','nombre'), array('empty' => 'Seleccione un estado...', 'class'=>'form-control'));?> 
       		<div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
		</div>
	</div>

	<div class="form-group"> 
		<div class="controls">
		<?php 
			if($model->provincia_id == ''){ 
				echo $form->dropDownListRow($model,'ciudad_id', array(), array('empty' => 'Seleccione una ciudad...', 'class'=>'form-control'));
			}else{
				echo $form->dropDownListRow($model,'ciudad_id', CHtml::listData(Ciudad::model()->findAllByAttributes(array('provincia_id'=>$model->provincia_id), array('order' => 'nombre')),'id','nombre'), array('class'=>'form-control'));
			}
		?>
			<div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
		</div>
	</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script>
	
	$('#DireccionFacturacion_provincia_id').change(function(){
		if($(this).val() != ''){
			var path = location.pathname.split('/');
			$.ajax({
			      url: "<?php echo Yii::app()->createUrl('direccionEnvio/cargarCiudades'); ?>",
			      type: "post",
			      data: { provincia_id : $(this).val() },
			      success: function(data){
			           $('#DireccionFacturacion_ciudad_id').html(data);
			      },
			});
		}
	});
	
</script>