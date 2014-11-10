<!-- CONTENIDO ON -->
<div class="container-fluid" style="padding: 0 15px;">
	
	<div class="row">

<?php
$this->breadcrumbs=array(
	'Ventas Flash'=>array('admin'),
	'Selección de producto',
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

        <div class="col-md-10  col-md-push-2 main-content" role="main">
        	<h1> Venta Flash </h1>
        	
        	<div class="well">
            <div class="row">
                <div class="col-md-6 1">
            	 
			<h4> Buscar producto en el catalogo de Telotengo.com </h4>
			
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
						'type'=>'primary',
						'label'=>'Buscar',
					)); ?>
					</div>
				</div>
				
			<?php $this->endWidget(); ?>	
						
			</div>
		</div>
		</div>
	</div>
	
</div>
</div>			