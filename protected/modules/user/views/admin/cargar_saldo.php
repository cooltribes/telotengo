<!-- CONTENIDO ON -->
<div class="container-fluid" style="padding: 0 15px;">
	<?php
	$this->breadcrumbs=array(
		'Usuarios'=>array('admin'),
		'Cargar Saldo',
	);
	?>

	<div class="row">
		<!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
		<div class="col-md-10  col-md-push-2 main-content" role="main">
			<div class="well">
				<div class="row padding_left_medium">
					<div class="col-md-6 1">
						<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
							'id'=>'saldo-form',
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

						<?php echo $form->errorSummary($balance); ?>

						<div class="form-group">
							<?php echo $form->textFieldRow($balance,'total',array('class'=>'form-control','maxlength'=>20,'placeholder'=>'Utilice punto para los decimales en caso de ser necesario (Ej: 810.23)')); ?>
						</div>

						<div class="form-actions">
							<?php 
							$this->widget('bootstrap.widgets.TbButton', array(
								'buttonType'=>'submit',
								'type'=>'primary',
								'label'=>'Cargar saldo',
							)); 
							?>
						</div>
						<?php $this->endWidget(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- COLUMNA PRINCIPAL DERECHA OFF // -->