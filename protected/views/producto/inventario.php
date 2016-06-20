<?php
$this->breadcrumbs=array(
        'Productos'=>array('productoInventario'),
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
								<?php
								/*if($numeroAlmacen>1)
								{
									echo $form->dropDownListRow(
								 	$model,'almacen_id', CHtml::listData(
								 		Almacen::model()->findAllByAttributes(array('empresas_id'=>$empresas_id)),'id','alias'
									), array(
										'class'=>'form-control',
										'empty' => 'Seleccione un almacen'
										)
									);
								}
								else
								{
									$almacenn=Almacen::model()->findByAttributes(array('empresas_id'=>$empresas_id));
									echo $form->dropDownListRow($model,'almacen_id',
										array($almacenn->id=>$almacenn->alias), 
										array('empty' => 'Seleccione un almacen','class'=>'form-control','options' => array($almacenn->id=>array('selected'=>true))));
								}*/

								//echo $form->error($model,'almacen_id'); 
								/*echo $form->dropDownListRow(
								 	$model,'almacen_id', CHtml::listData(
								 		Almacen::model()->findAllByAttributes(array('empresas_id'=>$empresas_id)),'id','alias'
									), array(
										'class'=>'form-control',
										'empty' => 'Seleccione un almacen',
										'options'=>array(''=>array('selected'=>true))
										)
									);*/
								$modelado=Almacen::model()->findAllByAttributes(array('empresas_id'=>$empresas_id));
								?>
								<label for="Inventario_almacen_id" class="required">Almacen <span class="required">*</span></label>
								<select id="Inventario_almacen_id" class="form-control" name="Inventario[almacen_id]">
								 <option value="">Seleccione un almacen</option>
								 <?php foreach($modelado as $mode): ?>
								  	<option value="<?php echo $mode->id;?>"><?php echo $mode->alias;?></option>
								  <?php endforeach;?>
								</select>
								
							</div> 
						<div id="contenido" class="hide">
							<div class="form-group">
								<label>SKU</label>
								<?php echo $form->textField($model,'sku',array('class'=>'form-control','maxlength'=>150)); ?>
								<?php echo $form->error($model,'sku'); ?>
							<span class="help-block text_align_left padding_right" >
		                    			<span class="help-block error" id="skuError" style="display: none;">Sku es obligatorio
		                    			</span>
                    				</span>	
							</div>
							
							<?php /*<div class="form-group"> 
								<label>Numero de parte del fabricante</label>
								<?php echo $form->textField($model,'numFabricante',array('class'=>'form-control','maxlength'=>150)); ?>
								<?php echo $form->error($model,'numFabricante');  ?>
							</div> */?>
							
							<div class="form-group"> 
								<label>Condicion <span class="required">*</span></label>
								 <?php echo $form->dropDownList($model,'condicion',array('nuevo'=>'Nuevo', 'usado'=>'Usado', 'reformado'=>'Reformado'),array('id'=>'condicion','class'=>'form-control','empty'=>'Seleccione condicion')); ?>
								<?php echo $form->error($model,'condicion');  ?>

							<span class="help-block text_align_left padding_right" >
		                    			<span class="help-block error" id="condicionError" style="display: none;">Conidicion no puede ser nulo
		                    			</span>
                    				</span>	
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
								<label>Precio <span class="required">*</span></label>
								<?php echo $form->textField($model,'precio',array('class'=>'form-control','id'=>'precio','maxlength'=>150, 'placeholder'=>'Precio para la venta (sin IVA)')); ?>
								<?php echo $form->error($model,'precio');  ?>
								<span class="help-block text_align_left padding_right" >
		                    			<span class="help-block error" id="precioError" style="display: none;">Precio no puede ser 0 u vacio
		                    			</span>
                    				</span>	
							</div>
							<div class="form-group"> 
                                <label>IVA a aplicar</label>
                                <div style="position: relative">
                                    <?php echo $form->textField($model,'iva',array('class'=>'form-control', 'id'=>'iva','maxlength'=>150, 'value'=>Yii::app()->params['IVA']['porcentaje'],'disabled'=>'disabled')); ?>
                                    <div style="position: absolute; right: 10px; top: 6px">%</div>
                                </div>
                                
                                <?php //echo $form->error($model,'iva');  ?>
                                
                            </div>
                            <div class="form-group"> 
                                <label>Precio con IVA <span class="required">*</span></label>
                                
                                <?php echo $form->textField($model,'precio_iva',array('class'=>'form-control','id'=>'precio_iva','maxlength'=>150, 'disabled'=>'disabled', 'placeholder'=>'Precio para la venta (con IVA)')); ?>
                                <?php echo $form->error($model,'precio_iva');  ?>
                                   <?php echo $form->hiddenField($model,'precio_iva'); ?>
                            </div>
													
							
							<div class="form-group">
								<label>Cantidad a Vender <span class="required">*</span></label>
								<?php echo $form->textField($model,'cantidad',array('class'=>'form-control','maxlength'=>50)); ?>
								<?php echo $form->error($model,'cantidad'); ?>
								<span class="help-block text_align_left padding_right" >
		                    			<span class="help-block error" id="cantidadError" style="display: none;">Cantidad a vender no puede ser 0 u vacio
		                    			</span>
                    				</span>	
							</div> 
							
							<div class="form-group">
								<label>Garantia</label>
								<?php  echo $form->textArea($model,'garantia',array('class'=>'form-control','maxlength'=>300)); ?>
								<?php echo $form->error($model,'garantia'); ?>
							</div> 
					</div>
						<?php /*	<div class="form-group">
								<label>Metodo de envio</label>
								 <?php echo $form->dropDownList($model,'metodoEnvio',array('1'=>'Acordado con el cliente', '2'=>'A traves del servicio de TELOTENGO'),array('id'=>'metodo','class'=>'form-control','empty'=>'Seleccione metodo de envio')); ?>
								<?php echo $form->error($model,'metodoEnvio'); ?>
							</div> */ ?>
							
							
						
							
							
							

							<?php
								
								echo CHtml::hiddenField('Inventario[producto_id]', $producto->id, array('id'=>'Inventario_producto_id'));
								
							?> 
                            <div class="form-group text_align_center">
							<?php $this->widget('bootstrap.widgets.TbButton', array(
								'buttonType'=>'submit',
								'htmlOptions'=>array('id'=>'botone','class'=>'btn btn-orange white margin_top_small','onclick'=>'$("precio_iva").removeAttr("disabled");'),
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
		var producto_id=<?php echo $_GET['id'];?>;
		var repetido=0;

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

		$('#Inventario_almacen_id').on('change', function(event) {
			
			$('#cantidadError').hide();
			$('#precioError').hide();
			$('#condicionError').hide();
			$('#skuError').hide();
			if($('#Inventario_almacen_id').val()=="")
			{
				$("#contenido").addClass("hide");
				///vaciar todos los campos
			}
			else
			{
				var almacen_id=$('#Inventario_almacen_id').val();
				var valorIva=<?php echo Yii::app()->params['IVA']['value']?>;
				
				$.ajax({
			         url: "<?php echo Yii::app()->createUrl('Producto/verificarCampos') ?>",
		             type: 'POST',
		             dataType:'json', 
			         data:{
		                    almacen_id:almacen_id, producto_id:producto_id,
		                   },
			        success: function (data) {
                       $('#Inventario_sku').val(data.sku);
                       $('#condicion').val(data.condicion);
                       $('#Inventario_costo').val(data.costo);
                       $('#Inventario_precio').val(data.precio);
                       $('#precio').val(data.precio);
                       if(data.precio=="")
                       {
                       		$('#precio').val('');
                       		//$('#precio').focus();
                       }
                       	precio_iva();
                       $('#Inventario_cantidad').val(data.cantidad);
                       $('#Inventario_garantia').val(data.garantia);
                       $("#contenido").removeClass("hide");
                        
                        
                    }
			    })
			}

			
		});
		
		
		$('#iva').focusout(function(){		   	    
		    precio_iva();
		});
		$('#precio').focusout(function(){                
            precio_iva();
        });
        $('#precio').on('keyup', function(event) {        
            precio_iva();
        });
        $('#Inventario_sku').on('change', function(event) {        
         
         var sku=$('#Inventario_sku').val();
         if(sku=="")
         {
         	$('#skuError').html("Sku es vacio");
			$('#skuError').show();
         }
         else
         {
         $.ajax({
			         url: "<?php echo Yii::app()->createUrl('Producto/verificarSkuCadaEmpresa') ?>",
		             type: 'POST',
			         data:{
		                    sku:sku, producto_id:producto_id,
		                   },
			        success: function (data) 
			        { 
			        	repetido=data;
			        	if(repetido==1)
			        	{
			        		$('#skuError').html("Sku es repetido");
			        		$('#skuError').show();
			        	}
			        	else
			        	{
			        		$('#skuError').hide();
                    	}	
                    }
			    })
         }

        });

     $('#botone').on('click', function(e) {        
            e.preventDefault();
            var retornar=0;
            var sku=$('#Inventario_sku').val();
            if(sku=="")
            	repetido=0;

		   if($('#Inventario_cantidad').val()<=0)
		   {
		   	 $('#cantidadError').show();
		   	 retornar=1;
		   }
		   else
		   	 $('#cantidadError').hide();

		   if($('#precio').val()<=0 || $('#precio').val()==null)
		   {
		   	 $('#precioError').show();
		   	 retornar=1;
		   }
		   else
		   	 $('#precioError').hide();

		   if($('#condicion').val()=="" || $('#condicion').val()==null)
		   {
		   	 $('#condicionError').show();
		   	 retornar=1;
		   }
		   else
		   	 $('#condicionError').hide();

		   if($('#Inventario_sku').val()=="" || $('#Inventario_sku').val()==null || repetido>0)
		   {
		   	 
		   	 
		   	 if(repetido>0)
		   	 	$('#skuError').html('Sku es repetido');
		   	 else
		   	 	$('#skuError').html('Sku es obligatorio');
		   	 
		   	 $('#skuError').show();
		   	 retornar=1;
		   }
		   else
		   	 $('#skuError').hide();

		   if(retornar==0)            
		   	$('#producto-form').submit();
            
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
                 $('#Inventario_precio_iva').val( $('#precio_iva'));
             
            }
            
		}
		
		
			
});	
	
</script>