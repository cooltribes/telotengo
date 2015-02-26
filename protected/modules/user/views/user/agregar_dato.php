<div class="container" style="padding: 0 15px;">
<h1>Agregar Red Social</h1>
<hr class="no_margin_top"> 	


<?php
$this->breadcrumbs=array(
	'Tu cuenta'=>array('tucuenta'),
	'Agregar Red Social',
);
?>


	<div class="row-fluid">
	



<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'social-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
    'type'=>'horizontal',
    'clientOptions'=>array(
        'validateOnSubmit'=>true, 
    ),
)); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="col-md-6 col-md-offset-3">
       
    
            <?php echo $form->dropDownListRow($model,'tipo_id', CHtml::listData(TipoRedes::model()->findAllByAttributes(array('estado'=>1)), 'id', 'nombre'), array('empty' => 'Seleccione...', 'class' => 'form-control')); ?>
        
            <?php echo $form->error($model,'tipo_id'); ?>
    </div>

   <div class="col-md-6 col-md-offset-3 margin_top_small">
     
         <?php echo $form->textFieldRow($model,'valor', array('class'=>'form-control', 'placeholder'=>'', 'maxlength'=>205)); ?>

        <?php echo $form->error($model,'valor'); ?>
    </div>

     <div class="col-md-6 col-md-offset-3">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Guardar',
            'htmlOptions'=>array('class'=>'form-control margin_top ')
        )); ?>

    </div>

<?php $this->endWidget(); ?>


</div>


</div>
</div>
