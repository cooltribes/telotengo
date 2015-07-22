<div class="container">
	<div class="row-fluid">
		<!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
		<div>
			<h1>Información Vital<small> - Nuevo producto</small></h1>
			<!-- Nav tabs -->
			<!-- SUBMENU ON -->
			<?php echo $this->renderPartial('_menu', array('model'=>$model, 'activo'=>'informacion_general')); ?>
			<!-- SUBMENU OFF -->

			<div class="well">
				<div class="row-fluid">
					<div>
						<?php 
						$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
							'id'=>'producto-form',
							'enableAjaxValidation'=>true,
							    'enableClientValidation'=>false,
								    'clientOptions'=>array(
								        'validateOnSubmit'=>true,
								    )
						));
						?>
							<?php echo $form->errorSummary($model); ?>
							<div class="form-group">
								<?php echo $form->labelEx($model,'nombre'); ?> 
								<?php echo $form->textField($model,'nombre',array('id'=>'nombre','class'=>'form-control','maxlength'=>150)); ?>
								<?php echo $form->error($model,'nombre'); ?>
								
									<span class="help-block muted text_align_left padding_right">
		                    			<span class="help-block error" id="esconder" style="display: block;">Nombre Ya existe
		                    			</span>
                    				</span>	
							</div>
							
							<div class="form-group">
								<?php echo $form->labelEx($model,'modelo'); ?> 
								<?php echo $form->textField($model,'modelo',array('class'=>'form-control','maxlength'=>150)); ?>
								<?php echo $form->error($model,'modelo'); ?>
							</div>
							
							<?php 
							if($model->padre_id=="")
							{
							?>
							<div class="form-group">
								<?php echo $form->labelEx($model,'padre_id'); 
								
								     $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
								    'id'=>'padre_id',
									'name'=>'padre_id',
								    'source'=>$this->createUrl('ProductoPadre/autocomplete'),
									'htmlOptions'=>array(
								          'size'=>100,
										  'placeholder'=>'Introduzca el producto padre',
										  'class'=>'form-control',
								          //'maxlength'=>45,
								        ),
								    // additional javascript options for the autocomplete plugin
								    'options'=>array(
								            'showAnim'=>'fold',
								    ),
									));
									?>
									<span class="help-block muted text_align_left padding_right" >
		                    			<span class="help-block error" id="errorUrl" style="display: block;">Nombre del Producto padre no existe
		                    			</span>
                    				</span>	
							<?php
							 }
							 else 
							 {

							 	 echo CHtml::textField('nombrePadre', $model->padre->nombre, array('id'=>'nombrePadre','class'=>'form-control','maxlength'=>100, 
										'width'=>100,'disabled'=>'disabled'));
                                 echo CHtml::hiddenField('padre_id', $model->padre->nombre);  
                                 
							 }
								?>
								

							</div>
													
							<div class="form-group">
								<label>Fabricante</label>
								<?php echo $form->textField($model,'fabricante',array('class'=>'form-control','maxlength'=>250)); ?>
								<?php echo $form->error($model,'fabricante');  ?>
							</div>
							
							<div class="form-group">
								<label>Año de fabricacion</label>
								<?php echo $form->textField($model,'annoFabricacion',array('class'=>'form-control','maxlength'=>20)); ?>
								<?php echo $form->error($model,'annoFabricacion');  ?>
							</div>

							
							<div class="form-group">
								<label>UPC</label>
								<?php echo $form->textField($model,'upc',array('class'=>'form-control','maxlength'=>50)); ?>
								<?php echo $form->error($model,'upc'); ?>
							</div>
							
							
							<div class="form-group">
								<label>EAN</label>
								<?php echo $form->textField($model,'ean',array('class'=>'form-control','maxlength'=>50)); ?>
								<?php echo $form->error($model,'ean'); ?>
							</div>
							
							<div class="form-group">
								<label>GTIN</label>
								<?php echo $form->textField($model,'gtin',array('class'=>'form-control','maxlength'=>50)); ?>
								<?php echo $form->error($model,'gtin'); ?>
							</div>
							
							<div class="form-group">
								<label>ISBN</label>
								<?php echo $form->textField($model,'isbn',array('class'=>'form-control','maxlength'=>50)); ?>
								<?php echo $form->error($model,'isbn'); ?>
							</div>
							
							<div class="form-group">
								<label>Color</label>
								<?php echo $form->textField($model,'color',array('class'=>'form-control','maxlength'=>50)); ?>
								<?php echo $form->error($model,'color'); ?>
							</div>
							
							<div class="form-group">
								<?php echo $form->labelEx($model,'color_id'); ?> 
								<?php echo $form->dropDownList($model,'color_id', CHtml::listData(Color::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'),array('id'=>'color_id','class'=>'form-control','empty'=>'Seleccione un Color')); ?>
								<?php echo $form->error($model,'color_id'); ?>
							</div>

							
						<!--	<div class="form-group">
								<label>Descripción</label>
								<?php $this->widget('ext.yiiredactor.widgets.redactorjs.Redactor', array( 'model' => $model, 'attribute' => 'descripcion' )); ?>
								<?php echo $form->error($model,'descripcion'); ?>
						</div> -->
  

							<!--
							<div class="form-group">     
								<label>Seleccione las categorías del producto</label>
								<div>
									<div class="col-xs-6">
										<?php 
										
										$prod_has = CategoriaHasProducto::model()->findAllByAttributes(array('producto_id'=>$model->id));
										$categoria = Categoria::model()->findAllByAttributes(array('id_padre'=>0));
										$uno;
										$dos;

										if(count($prod_has)>0){
											$uno = $prod_has[0];
											$dos = $prod_has[1];
											
											echo CHtml::dropDownList('cate_padre',$uno->categoria_id, CHtml::listData($categoria,'id','nombre'), array('empty' => 'Seleccione una categoría...', 'class' => 'form-control'));
										}
										else {

											echo CHtml::dropDownList('cate_padre','', CHtml::listData($categoria,'id','nombre'), array('empty' => 'Seleccione una categoría...', 'class' => 'form-control'));
										}

										?> 
									</div>
									<div class="col-xs-6">
										<?php
										 
										if(count($prod_has)>0){
											// se realiza la llamada al controlador para llenar el select	
											$datos = Producto::model()->hijos($uno->categoria_id);
											
											echo CHtml::dropDownList('cate_hijos',$dos->categoria_id, $datos, array('empty' => 'Seleccione la primera categoría...', 'class' => 'form-control'));
											
										}
										else
											echo CHtml::dropDownList('cate_hijos','', array(), array('empty' => 'Seleccione la primera categoría...', 'class' => 'form-control'));
										
										?>
									</div>

								</div>

							</div>
							-->
							<?php $this->widget('bootstrap.widgets.TbButton', array(
								'buttonType'=>'submit',
								'htmlOptions'=>array('class'=>'btn btn-primary margin_top_small form-control', 'id'=>'button_send'),
								'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar',
							)); ?>

						<?php $this->endWidget(); ?>
					</div>


				</div>
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
</div>
	<script>
	
$(document).ready(function() {
	 $('#esconder').hide();
	
	$('#padre_id').blur(function(){ 
		var nombre= $('#padre_id').val();
		$.ajax({
		         url: "<?php echo Yii::app()->createUrl('producto/verificarPadre') ?>",
	             type: 'POST',
		         data:{
	                    nombre:nombre, 
	                   },
		        success: function (data) {
					
					if(data==1)
					{
						  $('#errorUrl').hide();
	       				  $('#button_send').attr('disabled',false);
					}
					else
					{
						 $('#button_send').attr('disabled',true);
	        			 $('#errorUrl').show();
					}
		       	}
		       })
	});
	
	
		$('#nombre').blur(function(){ 
		var nombre= $('#nombre').val();
		$.ajax({
		         url: "<?php echo Yii::app()->createUrl('producto/verificarNombre') ?>",
	             type: 'POST',
		         data:{
	                    nombre:nombre, 
	                   },
		        success: function (data) {
					
					if(data==1)
					{
						 $('#button_send').attr('disabled',true);
	        			 $('#esconder').show();
					}
					else
					{
						  $('#esconder').hide();
	       				  $('#button_send').attr('disabled',false);
						 
					}
		       	}
		       })
	});

	
	
});	
		</script>
	
	
	
	
	
	

	
	
	
