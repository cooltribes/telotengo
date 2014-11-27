<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-push-2 main-content" role="main">
        <?php
        $this->breadcrumbs=array(
        	'Aplicar Gift Card',
        );
        ?>

        <?php if(Yii::app()->user->hasFlash('success')){?>
            <div class="alert in alert-block fade alert-success text_align_center">
                <?php echo Yii::app()->user->getFlash('success'); ?>
            </div>
        <?php } ?>
        <?php if(Yii::app()->user->hasFlash('error')){?>
            <div class="alert in alert-block fade alert-error text_align_center">
                <?php echo Yii::app()->user->getFlash('error'); ?>
            </div>
        <?php } ?>

        <div class="well">
        	<div class="row padding_left_medium">
        		<div class="col-md-6 1">

                <h3>Aplicar Gift Card</h3>
                <hr>

                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                    'id'=>'gift-form',
                    'enableAjaxValidation'=>false,
                    'enableClientValidation'=>true,
                    'type'=>'horizontal',
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true, 
                    ),
                )); ?> 

                <?php echo $form->errorSummary($model); ?>

                <div class="form-group">
                    <div class="col-md-2 control-label">Código</div>
                    <div class="col-sm-10">
                        <?php echo $form->textField($model,'codigo', array('class'=>'form-control', 'placeholder'=>'Ingrese el código')); ?>
                    </div>
                    <?php echo $form->error($model,'codigo'); ?>
                </div>

                <div class="form-actions">
                    <?php $this->widget('bootstrap.widgets.TbButton', array(
                        'buttonType'=>'submit',
                        'type'=>'primary',
                        'label'=>'Guardar',
                    )); ?>

                </div>

                <?php $this->endWidget(); ?>

                </div>
            </div>
        </div>
        </div>
    </div>
</div>
