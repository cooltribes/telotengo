    <div class="encabezado">
        <h1>Tienda Online B2B</h1>
        <h2>De Empresas para Empresas</h2>
       <div class="stripe">El primer marketplace exclusivo entre empresas.            
       </div>    
    </div>    
    
    <div class="row-fluid margin_top">
        <div class="col-md-5">
             <h4 class="text_align_right">Si quieres recibir una invitación incluye tu correo electrónico</h4>
        </div>
        
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
              
        <div class="col-md-5">
             <?php echo $form->emailField($model,'email', array('class'=>'form-control no-radius', 'placeholder'=>'Correo Electrónico')); ?>
             <?php echo $form->error($model,'email'); ?>
        </div>
        <div class="col-md-2">
             <?php echo CHtml::submitButton('Solicitar invitación', array('class'=>'btn-block btn-orange btn btn-danger btn-large')); ?> 
        </div>
        
        <?php $this->endWidget(); ?>
    </div>