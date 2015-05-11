<?php 
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration");
$this->breadcrumbs=array(
	UserModule::t("Registration"),
);
?>

<div class="container">
	<div class="row-fluid">
		<h1>Forma parte de Telotengo.com</h1>
                <hr class="no_margin_top"/>
		<div class="col-sm-12">
			<?php 
			if(Yii::app()->user->hasFlash('registration')): ?>
				<div class="success">
					<?php echo Yii::app()->user->getFlash('registration'); ?>
				</div>
			<?php else: ?>
				
				<div class="row-fluid">
				    <div class="col-md-10 col-md-offset-2">
				        <div class="col-sm-10 no_padding" style="text-align: center">
                            <div class="margin_top margin_bottom alert in alert-block fade alert-info text_align_center">
                                No hemos encontrado algún registro de invitación a este correo electrónico, <br/>
                                por lo que iniciaremos un proceso de validación que nos permitirá generar una para hacertela llegar a <?php echo Yii::app()->session['usuarionuevo']; ?>.
                            </div>
                            <div class="margin_top margin_bottom">
                                Por favor completa los siguientes datos personales
                            </div>
                       </div>    
                        
    				<div class="form-horizontal" role="form">
    					<?php $form=$this->beginWidget('UActiveForm', array(
    						'id'=>'registration-form',
    						'enableAjaxValidation'=>true,
    						'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
    						'clientOptions'=>array(
    							'validateOnSubmit'=>true,
    							'validateOnChange'=>false,
    							'validateOnType'=>false,
    						),
    						'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'form-horizontal','role'=>"form"),
    					)); ?>

    						<?php
    							echo CHtml::hiddenField('facebook_id','');
    						?>
    						
    						<div class="form-group">
    						    <div class="col-sm-10">
    						    	<?php echo $form->emailField($model,'email', array('class'=>'form-control', 'placeholder'=>'Correo Electrónico')); ?>
    						    </div>
    						    <?php echo $form->error($model,'email'); ?>
    						</div>
    
    
    						<br/>
                                <?php echo CHtml::submitButton('Solicitar invitación', array('class'=>'btn btn-success btn-lg col-sm-10')); ?>    						
    
    					<?php $this->endWidget(); ?>
				</div>
				<div class="align_center col-sm-10 margin_top">
                  <small>Si ya tienes una cuenta <?php echo CHtml::link('haz click aquí', $this->createUrl('/user/login'), array()); ?></small>  
                </div>
				</div>

				</div><!-- form -->
			<?php endif; ?>
		</div>
	</div>
</div>