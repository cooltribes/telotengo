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
    		<h1> Editar Inventario </h1>
        	
        
            	<div class="row-fluid well bg_white">
              
			
					<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
						'id'=>'busqueda-form',
						'enableAjaxValidation'=>false,
						'htmlOptions' => array('class' => 'padding_left_small'),
					)); ?>
				
					
						<div class="col-md-10 no_padding_right">
							<?php echo CHtml::textField("busqueda",'', array('class'=>'form-control no_radius_right no_padding_right','placeholder'=>'Busca el producto que deseas modificar')); ?>
						</div> 
					  
						<div class="col-md-2 no_padding_left">
						<?php $this->widget('bootstrap.widgets.TbButton', array(
							'buttonType'=>'submit',
					
							'label'=>'Buscar',
							'htmlOptions' => array('class'=>'btn btn-sigmablue form-control no_radius_left'),
						)); ?>
					   </div>	
		
				<?php $this->endWidget(); ?>	
				
			<h4> O Agregar un nuevo producto </h4>
			
			 <div class="control-group">
					<?php $this->widget('bootstrap.widgets.TbButton', array(
			    'label'=>'Añadir Producto',
			    'url' => Yii::app()->baseUrl.'/producto/clasificar',
			    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			    'size'=>'normal', // null, 'large', 'small' or 'mini'
			));  ?>
				</div> 
				
		
		</div>

	</div>
	
</div>
</div>		
<?php   if(isset($dataProvider)){
            $this->renderPartial('busqueda',array('dataProvider'=>$dataProvider)); 
        
        }
?>
	