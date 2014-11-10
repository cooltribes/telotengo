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
	'Agregar Documento',
);

?>

<h3>Agregar documento para: <?php echo $empresa->razon_social; ?></h3>
<hr>

<?php 
     
$form = $this->beginWidget(
    'CActiveForm',
    array(
        'id' => 'upload-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data','class'=>'form-horizontal'),
    )
);
?>

<div class="form-group">
	<?php echo $form->label($model,'tipo', array('class'=>'col-sm-2')); ?>
    <div class="col-sm-10">
    	<?php echo $form->dropDownList($model,'tipo', array(1=>'RIF', 2=>'Registro de comercio', 3=>'Última declaración ISLR', 4=>'Referencia bancaria', 9=>'Otro')); ?>
    </div>
    <?php echo $form->error($model,'tipo'); ?>
</div>

<div class="form-group" style="display: none" id="container_nombre">
    <?php echo $form->label($model,'nombre', array('class'=>'col-sm-2')); ?>
    <div class="col-sm-10">
        <?php echo $form->textField($model,'nombre', array('class'=>'form-control', 'placeholder'=>'', 'maxlength'=>45)); ?>
    </div>
    <?php echo $form->error($model,'nombre'); ?>
</div>

<div class="form-group">
    <div class="col-sm-10">
    	<?php echo $form->fileField($model,'ruta'); ?>
    </div>
    <?php echo $form->error($model,'ruta'); ?>
</div>

<?php echo $form->hiddenField($model,'empresas_id'); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>'Guardar',
	)); ?>

	<?php
	//echo CHtml::link('Cancelar', '/empresas/completar', array('class'=>'btn btn-default'));
	?>
</div>
<?php
$this->endWidget();
?>


</div>
</div>
</div>
</div>
</div>
</div>

<script type="text/javascript">
    $('#Documentos_tipo').on('change', switch_nombre);

    function switch_nombre(){
        if($('#Documentos_tipo').val() == 9){
        	$('#container_nombre').show('slow');
        //$('#container_nombre').attr('style','overflow: visible');	
        }else{
            $('#container_nombre').hide('slow');
        }
        console.log();
    }
</script>