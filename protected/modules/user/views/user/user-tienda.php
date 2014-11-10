<?php 
$this->breadcrumbs=array(
	'Usuarios'=>array('usuariostienda'),
	'Agregar',
);

?>

<div class="container">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-9 ">			
			
			
			<div class="form-horizontal margin_top" role="form">
					<?php $form=$this->beginWidget('UActiveForm', array(
						'id'=>'registration-form',
						'enableAjaxValidation'=>false,
						'clientOptions'=>array( 
							'validateOnSubmit'=>true,
						),
						'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'form-horizontal','role'=>"form"),
					)); ?>

						<!-- <p class="note"><?php //echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p> -->
						
						<?php echo $form->errorSummary(array($model,$profile)); ?>
						
						<div class="form-group">
							<label>Empresa</label>
							<?php
								echo CHtml::dropDownList('empresa','',$listData, array('class'=>'form-control')); 
							?>
						</div>
						
						<div class="form-group">
							<label>Email</label>
						    <?php echo $form->emailField($model,'email', array('class'=>'form-control', 'placeholder'=>'Correo Electrónico')); ?>
						    <?php echo $form->error($model,'email'); ?>
						</div>
						
						<div class="form-group">
							<label>Rol</label>
							<?php
								echo CHtml::dropDownList('rol','',array('Administrador'=>'Administrador','Vendedor'=>'Vendedor'), array('class'=>'form-control')); 
							?>
						</div>
						
						<br/>

						<div class="form-group">
							<?php $this->widget('bootstrap.widgets.TbButton', array(
								'buttonType'=>'submit',
								'htmlOptions'=>array('class'=>'btn btn-primary btn-lg'),
								'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar',
							)); ?>
						</div>

					<?php $this->endWidget(); ?>
				</div><!-- form --><br />
				
</div></div></div>