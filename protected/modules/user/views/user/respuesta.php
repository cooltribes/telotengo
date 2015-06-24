<div class="container">
	<div class="row-fluid">
		<h1>Forma parte de Telotengo.com</h1>
        <hr class="no_margin_top"/>
		<div class="col-sm-12">		

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

            <div class="margin_top margin_bottom alert in alert-block fade alert-info text_align_center"> 
                 <?php echo $user->email; ?>, encontramos tu correo electrónico en nuestra base de datos ya que el día
                 <?php echo date('l d',strtotime($user->create_at)); ?> de <?php echo date('F',strtotime($user->create_at)); ?> del
                 <?php echo date('Y',strtotime($user->create_at)); ?> hiciste una solicitud de invitación.<br/>
                 Pedimos disculpas por no haber podido atender a dicha solicitud aún y esperamos hacerlo prontamente.<br/><br/>
                 Dado que realizamos un proceso de validación robusto y manual para garantizar la veracidad de todos los integrantes,
                 hemos acumulado mucho trabajo y una lista en espera que seguimos actualizando. Una vez lleguemos a tu caso,
                 te contactaremos y invitaremos a participar. 
            </div>
            <div class="margin_top margin_bottom row-fluid">
            <!-- form -->
                Si hay alguna razón especial o comentario que nos quieras hacer, por favor escríbenos.
                
                <div class="form-horizontal col-md-12" role="form">
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
                     
                    <div class="col-md-8 col-md-offset-2 margin_top_small" >
                        <?php echo $form->textAreaRow($empresa,'comentario',array('class'=>'form-control no_resize','maxlength'=>250)); ?> 
                        <?php echo $form->error($empresa, 'comentario'); ?> 
                    </div>    

                    <div class="col-md-8 col-md-offset-2 margin_top_medium">
                        <?php $this->widget('bootstrap.widgets.TbButton', array(
                            'buttonType'=>'submit',
                            'type'=>'primary',
                            'label'=>'Enviar',
                            'htmlOptions'=>array('class'=>'form-control')
                        )); ?>
                    </div>
                    
                    <?php $this->endWidget(); ?>

                </div>

                <div class="center">
                    <a href="http://telotengo.com/new"><button type="button" class="btn btn-success">Ir al inicio</button></a> 
                </div>
            </div>
        </div>
    </div>
</div>