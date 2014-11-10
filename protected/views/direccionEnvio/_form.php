<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'direccion-envio-form',
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
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('class'=>'form-control','maxlength'=>65)); ?>
		<?php echo $form->error($model, 'nombre'); ?>
	</div>
	
	<div class="form-group"> 
		<?php echo $form->labelEx($model,'direccion_1'); ?>
		<?php echo $form->textField($model,'direccion_1',array('class'=>'form-control','maxlength'=>255)); ?>
		<?php echo $form->error($model, 'direccion_1'); ?>
	</div>
	<div class="form-group"> 
		<?php echo $form->labelEx($model,'direccion_2'); ?>
		<?php echo $form->textField($model,'direccion_2',array('class'=>'form-control','maxlength'=>255)); ?>
	</div>
	<div class="form-group"> 
		<?php echo $form->labelEx($model,'telefono'); ?>
		<?php echo $form->textField($model,'telefono',array('class'=>'form-control','maxlength'=>50)); ?>
		 <?php echo $form->error($model, 'telefono'); ?>
	</div>
	<div class="form-group"> 
		<div class="controls">
			<?php echo $form->labelEx($model,'provincia_id'); ?>
        	<?php echo $form->dropDownList($model,'provincia_id', CHtml::listData(Provincia::model()->findAll(array('order' => 'nombre')),'id','nombre'), array('empty' => 'Seleccione un estado...', 'class'=>'form-control'));?> 
       		<?php echo $form->error($model, 'provincia_id'); ?>
       		<!-- <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div> -->
		</div>
	</div>

	<div class="form-group"> 
		<div class="controls">
			<?php echo $form->labelEx($model,'ciudad_id'); ?>
			<?php 
				if($model->provincia_id == ''){ 
					echo $form->dropDownList($model,'ciudad_id', array(), array('empty' => 'Seleccione una ciudad...', 'class'=>'form-control'));
				}else{
					echo $form->dropDownList($model,'ciudad_id', CHtml::listData(Ciudad::model()->findAllByAttributes(array('provincia_id'=>$model->provincia_id), array('order' => 'nombre')),'id','nombre'), array('class'=>'form-control'));
				}
			?>
			<?php echo $form->error($model, 'ciudad_id'); ?>
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
	
	$('#DireccionEnvio_provincia_id').change(function(){
		if($(this).val() != ''){
			var path = location.pathname.split('/');
			$.ajax({
			      url: "<?php echo Yii::app()->createUrl('direccionEnvio/cargarCiudades'); ?>",
			      type: "post",
			      data: { provincia_id : $(this).val() },
			      success: function(data){
			           $('#DireccionEnvio_ciudad_id').html(data);
			      },
			});
		}
	});
	
</script>