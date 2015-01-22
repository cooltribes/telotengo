<div class="container">
	<?php
		$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
		$this->breadcrumbs=array(
			UserModule::t("Login"),
		);
	?>
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<h1><?php echo UserModule::t("Login"); ?></h1>

			<section>
        	<p><?php echo 'Por favor complete el formulario con los datos de su cuenta'; ?></p>
        		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
					'id'=>'login-form',
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
		            	 	<?php echo CHtml::activeLabelEx($model,'username'); ?>
		            		<?php echo $form->textFieldRow($model,'username',array("class"=>"form-control","placeholder"=>"correoelectronico@cuenta.com")); ?>
		            		<?php echo $form->error($model,'username'); ?>
		            	</div>  
		            </div>
            		<div class="control-group row-fluid"> 
             			<div class="controls">
	            			<?php echo CHtml::activeLabelEx($model,'password'); ?>
            				<?php echo $form->passwordFieldRow($model,'password',array('class'=>'form-control')); ?>
                     		<span class="help-block muted text_align_right padding_right">
                     		<?php echo $form->error($model,'password'); ?>
                		</div>
    				</div>

    				<div class="help-block">
						<p class="hint">
						<?php echo CHtml::link("Registro",Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link("Olvidé mi contraseña",Yii::app()->getModule('user')->recoveryUrl); ?>
						</p>
					</div>

	            	<?php echo $form->checkBoxRow($model,'rememberMe'); ?>
	            
	            	<div class="padding_top_medium padding_bottom_medium">
					<?php $this->widget('bootstrap.widgets.TbButton', array(
			            'buttonType'=>'submit',
			            'type'=>'danger',
			            'size'=>'large',
			            'label'=>"Iniciar sesión",
			            'htmlOptions'=>array('class'=>'btn-block'),
			        )); ?>
	        		</div>
          		</fieldset>

        	<?php $this->endWidget(); ?>
  			</section>
		
		</div>
	</div>
</div>

<?php
$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $model);
?>