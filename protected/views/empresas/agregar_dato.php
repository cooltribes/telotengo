<!-- CONTENIDO ON -->
    <div class="container-fluid" style="padding: 0 15px;">
	
	<div class="row">
        <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->

        <div class="col-md-10  col-md-push-2 main-content" role="main">
			<h1>Empresas<small> - Solicitud</small></h1>
	
<div class="well">
	<div class="row padding_left_medium">
		<div class="col-md-6 1">

<?php
$this->breadcrumbs=array(
	'Empresas'=>array('listado'),
	'Agregar Dato de contacto',
);
?>

<h3>Agregar dato de contacto para: <?php echo $empresa->razon_social; ?></h3>
<hr>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'empresas-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
    'type'=>'horizontal',
    'clientOptions'=>array(
        'validateOnSubmit'=>true, 
    ),
)); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->hiddenField($model,'empresa_id'); ?>

    <div class="form-group">
        <?php echo $form->label($model,'tipo_id', array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->dropDownList($model,'tipo_id', CHtml::listData(TiposDatosContacto::model()->findAll(), 'id', 'nombre')); ?>
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

        <?php
        echo CHtml::link('Cancelar', 'complete?empresa_id='.$model->empresa_id, array('class'=>'btn btn-default'));
        ?>
    </div>

<?php $this->endWidget(); ?>

</div>
</div>
</div>
</div>
</div>
</div>
