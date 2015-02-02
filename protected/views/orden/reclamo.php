<div class="container">

<?php
$this->breadcrumbs=array(
	'Pedidos'=>array('listado'),
	'Reclamo',
);
?>	
	
	<div class="row-fluid">
	    <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
	    <div>
            
			<?php if(Yii::app()->user->hasFlash('success')){?>
			    <div class="alert in alert-block fade alert-success text_align_center">
			        <?php echo Yii::app()->user->getFlash('success'); ?> 
			    </div>
			<?php } ?>
			<?php if(Yii::app()->user->hasFlash('error')){?>
			    <div class="alert in alert-block fade alert-danger text_align_center">
			        <?php echo Yii::app()->user->getFlash('error'); ?>
			    </div>
			<?php } ?>

            <h3>Resumen de la compra:</h3>
            <div class="well preguntaHeader margin_bottom"> 
            	Producto: <?php echo $orden_inventario->inventario->producto->nombre; ?></br>
				Fecha: <?php echo date('d-m-Y',strtotime($orden_inventario->orden->fecha)); ?>
            </div>

            <h3> Procesar Reclamo </h3>   
            <hr class="no_margin_top" />
                    
            <div class="well">
				<div class="row-fluid">
					<div>
						<?php
						$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
							'id'=>'reclamo-form',
							'enableAjaxValidation'=>false,
							'enableClientValidation'=>true,
							'type'=>'horizontal',
							'clientOptions'=>array(
								'validateOnSubmit'=>true, 
							),
							'htmlOptions' => array(
						        'enctype' => 'multipart/form-data',
						    ),
						));
						
						echo $form->errorSummary($reclamo);
						
						echo $form->label($reclamo,'comentario');
						echo $form->textArea($reclamo,'comentario',array('class'=>'form-control'));
						echo $form->error($reclamo,'comentario');

						echo '<div class="col-md-2 col-md-offset-10 margin_top_small no_padding">';
							$this->widget('bootstrap.widgets.TbButton', array(
								'buttonType'=>'submit',
								'type'=>'primary',
								'label'=>'Enviar',
								'htmlOptions' => array('class'=>'form-control'),
							));
						echo '</div>';

						$this->endWidget();
						?>
					</div>
				</div>


            </div>

            </div>
            <!-- COLUMNA PRINCIPAL DERECHA OFF // -->
        </div>
    </div>
</div>