<div class="container">
<?php
    $this->breadcrumbs=array(
        'Aplicar Gift Card',
    );
?>

    <h1>Aplicar Gift Card</h1>
    <hr class="no_margin_top">

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

        <div class="row-fluid margin_top">
            <div class="col-md-6 col-md-offset-3">
        		<div>

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
                    <div class="col-md-12">
                        <?php echo $form->textFieldRow($model,'codigo', array('class'=>'form-control', 'placeholder'=>'Ingrese el código')); ?>
                    </div>
                    <?php echo $form->error($model,'codigo'); ?>
                </div>

                <div class="form-actions">
                    <?php $this->widget('bootstrap.widgets.TbButton', array(
                        'buttonType'=>'submit',
                        'type' => 'danger',
                        'size' => 'large', 
                        'label'=>'Guardar',
                        'htmlOptions' => array('class'=>"form-control"),
                    )); ?>

                </div>

                <?php $this->endWidget(); ?>

                </div>
            </div>
        </div>

</div>
