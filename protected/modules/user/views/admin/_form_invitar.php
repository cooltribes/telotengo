<div class="form-horizontal margin_top" role="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
));
?>

	<?php echo $form->errorSummary(array($model,$profile)); ?>

	<div class="form-group">
		<div class="col-sm-12">
			<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-12">
			<?php echo $form->labelEx($model,'type'); ?>
			<?php echo $form->dropDownList($model,'type',User::itemAlias('UserType'),array('id'=>'User_type','class'=>'form-control','empty' => 'Seleccione una opción')); ?>
			<?php echo $form->error($model,'type'); ?>
		</div>
	</div>

	<?php
		$models = Empresas::model()->findAll();
		$list = CHtml::listData($models, 'id', 'razon_social'); 

	?>
	
	<div id="miembroEmpresa">
		<h3>Solo para el caso de invitar como miembro de empresa</h3>
		<div class="form-group">
		<div class="col-sm-12">
			<label>Empresa</label>
			<?php echo CHtml::dropDownList('empresas','',$list,array('id'=>'empresas','class'=>'form-control','disabled'=>'disabled')); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-12">
			<label>Cargo</label>
			<?php echo CHtml::dropDownList('cargo','',
				array(	'Dueño o Socio' => 'Dueño o Socio',
						'Junta Directiva' => 'Junta Directiva',
						'Gerente' => 'Gerente',
						'Empleado' => 'Empleado'),
				array('id'=>'cargo','class'=>'form-control','disabled'=>'disabled')); ?>
		</div>
	</div>
		
	</div>


	<div class="form-group">
	
		<div class="form-actions col-sm-offset-2 col-sm-10 no_margin">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=> 'Invitar',
			)); ?>
		</div> 

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	
$('#User_type').on('change', function() {
  //alert($(this).val()); 
  if($(this).val()==2){ // empresa
  	 $('#miembroEmpresa').show();
  	 $('#empresas').prop('disabled', false);
  	 $('#cargo').prop('disabled', false);
  }else{
  	 $('#miembroEmpresa').hide();
  	 $('#empresas').prop('disabled', 'disabled');
  	 $('#cargo').prop('disabled', 'disabled');
  }

});


</script>