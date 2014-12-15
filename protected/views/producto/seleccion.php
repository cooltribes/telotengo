<!-- CONTENIDO ON -->
<div class="container">
	<div class="row-fluid">
	<?php
	$this->breadcrumbs=array(
		'Productos'=>array('admin'),
		'Selección',
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

	 <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->

		<div>
    		<h1> Agregar inventario a producto </h1>
        	
        	<div class="well">
            	<div class="row">
                	<div class="col-md-6">
            		<div>Buscar producto a agregar inventario</div>
			
					<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
						'id'=>'busqueda-form',
						'enableAjaxValidation'=>false,
						'htmlOptions' => array('class' => 'padding_left_small'),
					)); ?>
				
					<div class="form-group">
						<div>
							<?php echo CHtml::textField("busqueda",'', array('class'=>'form-control')); ?>
						</div>
					
						<div class="form-actions">
						<?php $this->widget('bootstrap.widgets.TbButton', array(
							'buttonType'=>'submit',
							'type'=>'danger',
							'label'=>'Buscar',
							'htmlOptions' => array('class'=>'margin_top_small'),
						)); ?>
						</div>
					</div>
				<?php $this->endWidget(); ?>	
			<!--	
			<h4> O Agregar un nuevo producto </h4>
			
			 <div class="control-group"> -->
					<?php /*$this->widget('bootstrap.widgets.TbButton', array(
			    'label'=>'Añadir Producto',
			    'url' => Yii::app()->baseUrl.'/producto/create',
			    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			    'size'=>'normal', // null, 'large', 'small' or 'mini'
			)); */ ?>
			<!--	</div> -->
				
			</div>
		</div>
		</div>
	</div>
	
</div>
</div>			