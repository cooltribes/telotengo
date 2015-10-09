    <div class="col-md-6 col-md-offset-3 margin_top_large orangepanel">
        <h4 class="text-center">
            Introduce el correo electrónico asociado con tu cuenta en Telotengo
        </h4>
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
                        <?php echo $form->textFieldRow($model,'login_or_email',array("class"=>"form-control","placeholder"=>"correoelectronico@cuenta.com")); ?>
                        <?php echo $form->error($model,'login_or_email'); ?>
                    </div>  
                </div>

                <div class="padding_top_medium padding_bottom_medium text-center">
                    <?php $this->widget('bootstrap.widgets.TbButton', array(
                        'buttonType'=>'submit',
                        'label'=>"Recuperar",
                        'htmlOptions'=>array('class'=>'btn-black btn btn-danger btn-large padding_left padding_right'),
                    )); ?>
                </div>

            </fieldset>

            <?php $this->endWidget(); ?>
            <h4 class="text-center">
                <b>Te enviaremos a tu correo electrónico un enlace a una página donde fácilmente podrás crear una nueva contraseña.</b>
            </h4>
        
    </div>
