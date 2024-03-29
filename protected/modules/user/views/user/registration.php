    <div class="encabezado">
        <h1>Tienda Online B2B</h1>
        <h2>De Empresas para Empresas</h2>
       <div class="stripe">El primer marketplace exclusivo entre empresas. 
           
       </div>    
    </div>    
    
    <div class="row-fluid margin_top">
        <div class="col-md-5 col-sm-5">
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
              
        <div class="col-md-5 col-sm-4">
             <?php echo $form->emailField($model,'email', array('class'=>'form-control no-radius', 'placeholder'=>'Correo Electrónico', 'id'=>'email')); ?>
             <?php echo $form->error($model,'email'); ?>
             <div class="text-center white" id="email_error">
                 
             </div>
        </div>
        <div class="col-md-2 col-sm-3 no_horizontal_padding text_align_center">
             <?php echo CHtml::button('Solicitar invitación', array('id'=>'submit-btn','class'=>'btn-block btn-orange btn btn-danger','onclick'=>'exists()')); ?> 
        </div>
        
        <?php $this->endWidget(); ?>
    </div>
    
<script>
    function exists(){
        
       email= $('#email').val();
    
            $.ajax({
                  url: "registration/emailExists",
                  type: "post",
                  dataType:'json',
                  data: { email:email },
                  success: function(data){
                      if(data.status=="ok"){
                              $('#registration-form').submit();                      
                      }else{
                          $("#email_error").html('<small>'+data.message+'</small>');
                       
                      }
                      
                  },
            });            
   
        
    }
</script>