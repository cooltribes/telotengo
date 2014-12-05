<div class="container">
	<div class="row">
	     
		<div class="col-md-offset-4 col-md-4">
		    <h1>Ingresar</h1>
            <div class="margin_bottom" style="text-align: center"><small>Por favor introduce tus datos de inicio de sesión para continuar con tu compra</small></div>
			<?php if(Yii::app()->user->hasFlash('error')): ?>
   
			<div class="has-error">
				<?php echo Yii::app()->user->getFlash('error'); ?>
			</div>
 
			<?php endif; ?>
             
			<div class="form "> 
				<?php 
				$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
					'id'=>'caracteristica-form',
					'enableAjaxValidation'=>false,
					'htmlOptions'=>array(),
				));
				?>  

				
				
				<?php echo $form->errorSummary($model); ?>
				
				<div class="form-group">
					<label>Usuario</label>
					<?php echo $form->textFieldRow($model,'username',array("class"=>"form-control","value"=>Yii::app()->user->name,'readonly'=>true)); ?>
					<?php echo $form->error($model,'username'); ?>
					<?php // echo $form->textField($model,'username', array('class'=>'form-control','placeholder'=>'Username or Email') ) ?>
				</div>
				
				<div class="form-group">
					<label>Contraseña</label>
					<?php echo $form->passwordField($model,'password', array('class'=>'form-control','placeholder'=>'Password') ) ?>
				</div>

				<div class="submit">
					<?php
					$this->widget('bootstrap.widgets.TbButton', array(
								'buttonType'=>'submit',
								'url'=>$this->createUrl('authenticate'),
								'htmlOptions'=>array('class'=>'btn btn-primary btn-lg'),
								'label'=>'Continuar',
							)); 
					?>
					<?php //echo $form->submitButton(UserModule::t("Login"), array('class'=>'btn btn-default')); ?>
				</div>
				
				<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
</div>

