<div class="container-fluid" style="padding: 0 15px;">
	
<div class="row">
<div class="col-md-10 col-md-push-2 main-content" role="main">

<?php
$this->breadcrumbs=array(
	'Tu cuenta'=>array('tucuenta'),
	'Agregar Red Social',
);
?>

<div class="well">
	<div class="row padding_left_medium">
		<div class="col-md-6 1">

<h3>Agregar Red Social</h3>
<hr>

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

    <div class="form-group">
        <?php echo $form->label($model,'tipo_id', array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->dropDownList($model,'tipo_id', CHtml::listData(TipoRedes::model()->findAllByAttributes(array('estado'=>1)), 'id', 'nombre'), array('empty' => 'Seleccione...', 'class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($model,'tipo_id'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'valor', array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model,'valor', array('class'=>'form-control', 'placeholder'=>'', 'maxlength'=>205)); ?>
        </div>
        <?php echo $form->error($model,'valor'); ?>
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
