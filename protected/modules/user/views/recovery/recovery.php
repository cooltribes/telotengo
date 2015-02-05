<div class="container">
	<?php

	$this->pageTitle= Yii::app()->name . ' - Recuperar Contraseña';
	
	$this->breadcrumbs=array(
		'Iniciar sesión' => array('/user/login'),
		'Recuperar contraseña',
	);
	?>
	<div class="row-fluid">
		<h1><?php echo 'Recuperar contraseña'; ?></h1>
		<hr class="no_margin_top" />

		<div class="col-md-offset-2 col-md-8">

			<div class="well bg_white">
			
			<?php if(Yii::app()->user->hasFlash('success')){?>
			    <div class="alert in alert-block fade alert-success text_align_center">
			        <?php echo Yii::app()->user->getFlash('success'); ?>
			    </div>
			<?php } ?>
			<?php if(Yii::app()->user->hasFlash('error')){?>
			    <div class="alert in alert-block fade alert-danger text_align_center">
			        <?php echo Yii::app()->user->getFlash('error'); ?>
			    </div>
			<?php } ?>

			<?php echo CHtml::beginForm(); ?>

			<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				'id'=>'recovery-form',
				'htmlOptions'=>array('class'=>''),
			    'type'=>'inline',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
				),
			)); ?>

			<fieldset>             
	            <div class="control-group row-fluid">
	            	 <div class="controls">
	            	 	<?php echo CHtml::activeLabelEx($model,'login_or_email'); ?>
	            		<?php echo $form->textFieldRow($model,'login_or_email',array("class"=>"form-control","placeholder"=>"correoelectronico@cuenta.com")); ?>
	            		<?php echo $form->error($model,'login_or_email'); ?>
	            	</div>  
	            </div>

            	<div class="padding_top_medium padding_bottom_medium">
					<?php $this->widget('bootstrap.widgets.TbButton', array(
			            'buttonType'=>'submit',
			            'type'=>'danger',
			            'size'=>'large',
			            'label'=>"Recuperar",
			            'htmlOptions'=>array('class'=>'btn-block'),
			        )); ?>
        		</div>

		    </fieldset>

			<?php $this->endWidget(); ?>
			</div>
		</div>
	</div>
</div>