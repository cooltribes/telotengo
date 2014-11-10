<!-- CONTENIDO ON -->
<div class="container-fluid" style="padding: 0 15px;">
	
	<div class="row">
<?php
$this->breadcrumbs=array(
	'Productos'=>array('admin'),
	'SEO',
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
        	<h1>SEO<small> - Registar nuevo producto</small></h1>
			
			<!-- Nav tabs -->
			<?php echo $this->renderPartial('_menu', array('model'=>$model,'activo'=>'seo')); ?> 
 
	<div class="well">
            <div class="row">
                <div class="col-md-6 1">
					
									  
				  <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
					'id'=>'seo-form',
					'enableAjaxValidation'=>false,
					'htmlOptions' => array('class' => 'padding_left_small'),
				)); ?>
				
					<?php echo $form->errorSummary($model); ?>
					
		            <div class="form-group">
		              	<?php echo $form->textFieldRow($seo, 'descripcion', array('class'=>'form-control')); ?>
		                <div class=" muted">Descripción del producto para mostrar a los buscadores web</div>
		            </div>
		            
            		<div class="form-group">
                 		<?php echo $form->textFieldRow($seo, 'tags', array('class'=>'form-control')); ?>
                		<div class=" muted">Lista de palabras clave relacionadas con el producto, separadas por coma (,)</div>
                	</div>
            
		            <div class="form-group">
						<?php echo $form->textFieldRow($seo, 'amigable', array('class'=>'form-control', 'placeholder'=>'Ejemplo: prenda-color-marca')); ?>
		                <div class=" muted">Dirección URL del producto</div>
		            </div>
		            
					
				<div class="form-actions">
					<?php $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'type'=>'primary',
						'label'=>'Guardar',
					)); ?>
				</div>
					
      			</div>
    		</div>
	</div> 
   <?php $this->endWidget(); ?>

   
  </div>
   
</div>
<!-- /container -->


<script>
 
 function valSeo(){
	 var exp= /^\w{1}([a-zA-Z_|\-]*[a-zA-Z]+[a-zA-Z_|\-]*)$/;
	 var val=$('#Seo_urlAmigable').val();
	 if(val.match(exp))
	 	return true;
	else
		return false;	
	}		
		
</script>
