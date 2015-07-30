    <div class="encabezado">
        <h1>TIENDA ONLINE B2B</h1>
        <h2>De Empresas para empresas</h2>
        <div class="row"><h3>El primer market place donde las Empresas se compran y se venden entre ellas.</h3> </div>    
    </div>    
    
    <div class="row-fluid">
        <div class="col-md-5">
             <h4 class="text_align_left">Si has recibido una invitación o quieres recibir una incluye tu correo electrónico</h4>
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
             <?php echo $form->emailField($model,'email', array('class'=>'form-control', 'placeholder'=>'Correo Electrónico')); ?>
             <?php echo $form->error($model,'email'); ?>
        </div>
        <div class="col-md-2">
             <?php echo CHtml::submitButton('Solicitar invitación', array('class'=>'btn btn-success btn-lg')); ?> 
        </div>
        
        <?php $this->endWidget(); ?>
    </div>