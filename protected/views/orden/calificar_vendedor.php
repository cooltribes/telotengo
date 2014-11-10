<div class="container-fluid" style="padding: 0 15px;">

<?php
$this->breadcrumbs=array(
	'Pedidos'=>array('listado'),
	'Detalle',
);
?>	
	
	
    <div class="container">
        <div class="row">
            <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
            <div class="col-md-10 col-md-offset-1 main-content" role="main">
                <div class="page-header">
                    <h1>
                       Calificar vendedor
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
								'id'=>'calificacion-form',
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
							
							echo $form->errorSummary($calificacion);
							
							echo '<div class="form-group">';
							echo $form->label($calificacion,'puntuacion');
							echo CHtml::link('<span id="calificacion_1" class="glyphicon glyphicon-star-empty"></span>', '', array('onclick'=>'set_calificacion(1)', 'style'=>'cursor: pointer;'));
							echo CHtml::link('<span id="calificacion_2" class="glyphicon glyphicon-star-empty"></span>', '', array('onclick'=>'set_calificacion(2)', 'style'=>'cursor: pointer;'));
							echo CHtml::link('<span id="calificacion_3" class="glyphicon glyphicon-star-empty"></span>', '', array('onclick'=>'set_calificacion(3)', 'style'=>'cursor: pointer;'));
							echo CHtml::link('<span id="calificacion_4" class="glyphicon glyphicon-star-empty"></span>', '', array('onclick'=>'set_calificacion(4)', 'style'=>'cursor: pointer;'));
							echo CHtml::link('<span id="calificacion_5" class="glyphicon glyphicon-star-empty"></span>', '', array('onclick'=>'set_calificacion(5)', 'style'=>'cursor: pointer;'));
							echo $form->hiddenField($calificacion,'puntuacion');
							echo '</div>';
							
							echo '<div class="form-group">';
							echo $form->label($calificacion,'comentario');
							echo $form->textArea($calificacion,'comentario',array('class'=>'form-control'));
							echo $form->error($calificacion,'comentario');
							echo '</div>';

							echo '<div class="form-actions">';
								$this->widget('bootstrap.widgets.TbButton', array(
									'buttonType'=>'submit',
									'type'=>'primary',
									'label'=>'Calificar',
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
<script>
	function set_calificacion(puntaje){
		$('#CalificacionEmpresa_puntuacion').val(puntaje);
		$('.glyphicon').removeClass('glyphicon-star-empty');
        $('.glyphicon').removeClass('glyphicon-star');
		switch(puntaje){
			case 1:
				$('#calificacion_1').addClass('glyphicon-star');
	            $('#calificacion_2').addClass('glyphicon-star-empty');
	            $('#calificacion_3').addClass('glyphicon-star-empty');
	            $('#calificacion_4').addClass('glyphicon-star-empty');
	            $('#calificacion_5').addClass('glyphicon-star-empty');
	            break;
	        case 2:
				$('#calificacion_1').addClass('glyphicon-star');
	            $('#calificacion_2').addClass('glyphicon-star');
	            $('#calificacion_3').addClass('glyphicon-star-empty');
	            $('#calificacion_4').addClass('glyphicon-star-empty');
	            $('#calificacion_5').addClass('glyphicon-star-empty');
	            break;
	        case 3:
				$('#calificacion_1').addClass('glyphicon-star');
	            $('#calificacion_2').addClass('glyphicon-star');
	            $('#calificacion_3').addClass('glyphicon-star');
	            $('#calificacion_4').addClass('glyphicon-star-empty');
	            $('#calificacion_5').addClass('glyphicon-star-empty');
	            break;
	        case 4:
				$('#calificacion_1').addClass('glyphicon-star');
	            $('#calificacion_2').addClass('glyphicon-star');
	            $('#calificacion_3').addClass('glyphicon-star');
	            $('#calificacion_4').addClass('glyphicon-star');
	            $('#calificacion_5').addClass('glyphicon-star-empty');
	            break;
	        case 5:
				$('#calificacion_1').addClass('glyphicon-star');
	            $('#calificacion_2').addClass('glyphicon-star');
	            $('#calificacion_3').addClass('glyphicon-star');
	            $('#calificacion_4').addClass('glyphicon-star');
	            $('#calificacion_5').addClass('glyphicon-star');
	            break;
		}
	}
</script>