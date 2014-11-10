<div class="container-fluid" style="padding: 0 15px;">

<?php
$this->breadcrumbs=array(
	'Pedidos'=>array('listado'),
	'Reclamo',
);
?>	
	
	
    <div class="container">
        <div class="row">
            <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
            <div class="col-md-10 col-md-offset-1 main-content" role="main">
                <div class="page-header">
                    <h1>
                       Procesar reclamo
                    </h1> 
                </div>   
                    
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
                    
                <section>
                    <h3>Resumen de la compra:</h3>
                    <div>
                        <p class="well well-sm"> 
                        	Vendedor: <?php echo $orden_inventario->inventario->almacen->empresas->razon_social; ?></br>
                        	Producto: <?php echo $orden_inventario->inventario->producto->nombre.' | '.$caracteristicas; ?>
						</p>
                    </div>

                    <div class="well">
						<div class="row padding_left_medium">
							<div class="col-md-6 1">
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
							
							echo '<div class="form-group">';
							echo $form->label($reclamo,'comentario');
							echo $form->textArea($reclamo,'comentario',array('class'=>'form-control'));
							echo $form->error($reclamo,'comentario');
							echo '</div>';

							echo '<div class="form-actions">';
								$this->widget('bootstrap.widgets.TbButton', array(
									'buttonType'=>'submit',
									'type'=>'primary',
									'label'=>'Enviar',
								));
							echo '</div>';
	
							$this->endWidget();
							?>
							</div>
						</div>
					</div>


                </section>

            </div>
            <!-- COLUMNA PRINCIPAL DERECHA OFF // -->
        </div>
    </div>
</div>