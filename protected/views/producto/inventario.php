<?php 
$this->breadcrumbs=array(
        'Productos'=>array('admin'),
        'Inventario',
    );?>

	
		<!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
		<div class="margin_top_large">
			<h2>Inventario para : <small><?php echo $producto->nombre; ?></small></h2>
			<hr class="no_margin_top" />
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
			
			<!-- Nav tabs -->
			<!-- SUBMENU ON --><?php
			if(Yii::app()->authManager->checkAccess("admin", Yii::app()->user->id))
			{
				 echo $this->renderPartial('_menu', array('model'=>$producto, 'activo'=>'inventario')); 
			}?>
			<!-- SUBMENU OFF -->

<div class="col-md-6 col-md-offset-3">		
			
					<div>
						<?php 
						$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
							'id'=>'producto-form',
							'enableAjaxValidation'=>false,
						));
						?> 
							<?php echo $form->errorSummary($model); ?>
							<div class="form-group">
								<label>SKU</label>
								<?php echo $form->textField($model,'sku',array('class'=>'form-control','maxlength'=>150)); ?>
								<?php echo $form->error($model,'sku'); ?>
							</div>
							
							<?php /*<div class="form-group"> 
								<label>Numero de parte del fabricante</label>
								<?php echo $form->textField($model,'numFabricante',array('class'=>'form-control','maxlength'=>150)); ?>
								<?php echo $form->error($model,'numFabricante');  ?>
							</div> */?>
							
							<div class="form-group"> 
								<label>Condicion *</label>
								 <?php echo $form->dropDownList($model,'condicion',array('nuevo'=>'Nuevo', 'usado'=>'Usado', 'reformado'=>'Reformado'),array('id'=>'condicion','class'=>'form-control','empty'=>'Seleccione condicion')); ?>
								<?php echo $form->error($model,'condicion');  ?>
							</div>
							
							<div class="form-group" id='notaCondicion' style="display:none">
								<label>Nota de Condicion</label>
								<?php  echo $form->textArea($model,'notaCondicion',array('class'=>'form-control','maxlength'=>300)); ?>
								<?php echo $form->error($model,'notaCondicion'); ?>
							</div> 
							
							<div class="form-group"> 
								<label>Costo</label>
								<?php echo $form->textField($model,'costo',array('class'=>'form-control','maxlength'=>150, 'placeholder'=>'Costo')); ?>
								<?php echo $form->error($model,'costo');  ?>
							</div>
							
							<div class="form-group"> 
								<label>Precio *</label>
								<?php echo $form->textField($model,'precio',array('class'=>'form-control','id'=>'precio','maxlength'=>150, 'placeholder'=>'Precio para la venta (sin IVA)')); ?>
								<?php echo $form->error($model,'precio');  ?>
							</div>
							<div class="form-group"> 
                                <label>IVA a apicar *</label>
                                <div style="position: relative">
                                    <?php echo $form->textField($model,'iva',array('class'=>'form-control', 'id'=>'iva','maxlength'=>150, 'placeholder'=>'IVA a aplicar')); ?>
                                    <div style="position: absolute; right: 10px; top: 6px">%</div>
                                </div>
                                
                                <?php echo $form->error($model,'iva');  ?>
                                
                            </div>
                            <div class="form-group"> 
                                <label>Precio con IVA *</label>
                                <?php echo $form->textField($model,'precio_iva',array('class'=>'form-control','id'=>'precio_iva','maxlength'=>150, 'disabled'=>'disabled', 'placeholder'=>'Precio para la venta (con IVA)')); ?>
                                <?php echo $form->error($model,'precio_iva');  ?>
                            </div>
													
							
							<div class="form-group">
								<label>Cantidad a Vender *</label>
								<?php echo $form->textField($model,'cantidad',array('class'=>'form-control','maxlength'=>50)); ?>
								<?php echo $form->error($model,'cantidad'); ?>
							</div> 
							
							<div class="form-group">
								<label>Garantia</label>
								<?php  echo $form->textArea($model,'garantia',array('class'=>'form-control','maxlength'=>300)); ?>
								<?php echo $form->error($model,'garantia'); ?>
							</div> 
							
						<?php /*	<div class="form-group">
								<label>Metodo de envio</label>
								 <?php echo $form->dropDownList($model,'metodoEnvio',array('1'=>'Acordado con el cliente', '2'=>'A traves del servicio de TELOTENGO'),array('id'=>'metodo','class'=>'form-control','empty'=>'Seleccione metodo de envio')); ?>
								<?php echo $form->error($model,'metodoEnvio'); ?>
							</div> */ ?>
							
							<div class="form-group">
								<?php
								echo $form->dropDownListRow(
								 	$model,'almacen_id', CHtml::listData(
								 		Almacen::model()->findAllByAttributes(array('empresas_id'=>$empresas_id)),'id','alias'
									), array(
										'class'=>'form-control',
										'empty' => 'seleccione un almacen'
										)
									);
								//echo $form->error($model,'almacen_id'); ?>
							</div> 
							
						
							
							
							

							<?php
								
								echo CHtml::hiddenField('Inventario[producto_id]', $producto->id, array('id'=>'Inventario_producto_id'));
								
							?> 
                            <div class="form-group text_align_center">
							<?php $this->widget('bootstrap.widgets.TbButton', array(
								'buttonType'=>'submit',
								'htmlOptions'=>array('class'=>'btn btn-orange white margin_top_small'),
								'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar',
							)); ?>
                            </div> 
						<?php $this->endWidget(); ?>
					</div> 


		
		
			<?php
			/*$template = '{summary}
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
				<tr>
				<th rowspan="2" scope="col">Caracteristica</th>
				<th rowspan="2" scope="col">Valor</th>
				<th rowspan="2" scope="col">Acción</th>
				</tr>
				{items}
				</table>
				{pager} 
			';

			$this->widget('zii.widgets.CListView', array(
				'id'=>'list-auth-caracteristicas',
				'dataProvider'=>$model->search(),
				'itemView'=>'_datos',
				'template'=>$template,
				'enableSorting'=>'true',
				'afterAjaxUpdate'=>" function(id, data) {

				} ",
				'pager'=>array(
					'header'=>'',
					'htmlOptions'=>array(
						'class'=>'pagination pagination-right',
					)
				),					
			));  */

			?>
		</div>

		<!-- COLUMNA PRINCIPAL DERECHA OFF // -->


</div>

<script>
	$(document).ready(function() {

		$('#condicion').on('change', function(event) {
			
			if($('#condicion').val()=="usado" || $('#condicion').val()=="reformado")
			{
				$('#notaCondicion').show();
			}
			else
			{
				$('#notaCondicion').hide();
			}
		});
		
		
		$('#iva').focusout(function(){		   	    
		    precio_iva();
		});
		$('#precio').focusout(function(){                
            precio_iva();
        });
		
		function precio_iva(){
		    price=parseFloat($('#precio').val().replace(',','.'));        
            iva=parseFloat($('#iva').val().replace(',','.'));
            if(price!=''&&iva!=''){
                if(!isNaN(price)&&!isNaN(iva)){
                     $('#precio_iva').val((price*iva/100)+price);
                }
                if(isNaN(price)){
                    $('#precio').val('');
                    $('#precio').focus();
                } 
                if(isNaN(iva)){
                    $('#iva').val('');
                    $('#iva').focus();
                }   
            }
            
		}
		
		
			
});	
	
</script>