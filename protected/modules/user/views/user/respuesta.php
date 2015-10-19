<?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado"); 
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");?>


        <h3 class="text-center margin_top_large">
            <b>Forma parte de Telotengo.com</b>
        </h3>
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
        <div class="gray-block text-center margin_top_large">
        <p>
            <?php echo $user->email; ?>, encontramos tu correo electrónico en nuestra base de datos ya que el día
                 <?php echo $dias[date('w', strtotime($user->create_at))]." "; echo date('d',strtotime($user->create_at)); ?> de <?php echo $meses[date('n',strtotime($user->create_at))-1]; ?> del
                 <?php echo date('Y',strtotime($user->create_at)); ?> hiciste una solicitud de invitación.<br/>
                 Pedimos disculpas por no haber podido atender a dicha solicitud aún y esperamos hacerlo prontamente.
       </p>
       <p>                 Dado que realizamos un proceso de validación robusto y manual para garantizar la veracidad de todos los integrantes,
                 hemos acumulado mucho trabajo y una lista en espera que seguimos actualizando. Una vez lleguemos a tu caso,
                 te contactaremos y invitaremos a participar. 
            
        </p>      
      
        </div>             <p class="margin_top" style="color:#FFF">Si hay alguna razón especial o comentario que nos quieras hacer, por favor escríbenos.</p>       
    
        <div class="form-horizontal col-md-6 col-md-offset-3" role="form">
                    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                        'id'=>'comentario-form',
                        'enableAjaxValidation'=>false,
                        'enableClientValidation'=>true,
                        'type'=>'horizontal',
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true, 
                        ),
                        'htmlOptions' => array(
                            'enctype' => 'multipart/form-data', 
                            
                        ),
                    )); ?>
                     
                    <div class="margin_top_small" style="color:#FFF" >
                        <?php echo $form->textAreaRow($empresa,'comentario',array('class'=>'form-control no_resize no_radius','maxlength'=>250,'rows'=>4)); ?> 
                        <?php echo $form->error($empresa, 'comentario'); ?> 
                    </div>    

                    <div class="margin_top_medium text-center">
                        <?php $this->widget('bootstrap.widgets.TbButton', array(
                            'buttonType'=>'submit',
                            'type'=>'primary',
                            'label'=>'Enviar',
                            'htmlOptions'=>array('class'=>'btn btn-danger btn-orange padding_left padding_right')
                        )); ?>
                       
                    </div>
                    <div class="text-center margin_top_small ">
                         <a class="white-link" style="font-size: 14px;" href="<?php echo Yii::app()->getBaseUrl(true); ?>"><b>Ir al inicio</b></a> 
                    </div>
                    
                    <?php $this->endWidget(); ?>

                </div>
                 
        
                



