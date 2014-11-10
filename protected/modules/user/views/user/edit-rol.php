<?php 
$this->breadcrumbs=array(
	'Usuarios'=>array('usuariostienda'),
	'Editar Rol',
);

?>

<div class="container">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-9 ">				
			
			<div class="form-horizontal margin_top" role="form">
					<?php $form=$this->beginWidget('UActiveForm', array(
						'id'=>'registration-form',
						'enableAjaxValidation'=>false,
						'clientOptions'=>array( 
							'validateOnSubmit'=>true,
						),
						'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'form-horizontal','role'=>"form"),
					)); ?>
						<h3>Editar rol para: <small><?php echo $usuario; ?></small></h3>
						<div class="form-group">
							<label>Rol</label>
							<?php
							
							if($rol)						
								echo CHtml::dropDownList('rol',$rol,array('Administrador'=>'Administrador','Vendedor'=>'Vendedor'), array('class'=>'form-control')); 
							else
								echo CHtml::dropDownList('rol','',array('Administrador'=>'Administrador','Vendedor'=>'Vendedor'), array('class'=>'form-control')); 
								
							?>
						</div>
						
						<br/>

						<div class="form-group">
							<?php $this->widget('bootstrap.widgets.TbButton', array(
								'buttonType'=>'submit',
								'htmlOptions'=>array('class'=>'btn btn-primary btn-lg'),
								'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar',
							)); ?>
						</div>

					<?php $this->endWidget(); ?>
				</div><!-- form --><br />
				
</div></div></div>