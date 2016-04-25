
		<!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
		<div>
			<h1>Información Vital<small> - Nuevo producto</small></h1>
			<!-- Nav tabs -->
			<!-- SUBMENU ON -->
			<?php echo $this->renderPartial('_menu', array('model'=>$model, 'activo'=>'informacion_general')); ?>
			<!-- SUBMENU OFF -->

	
				<div class="row-fluid">
					<div>
						<?php 
						$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
							'id'=>'producto-form',
							'enableAjaxValidation'=>true,
							    'enableClientValidation'=>false,
								    'clientOptions'=>array(
								        'validateOnSubmit'=>false,
								    )
						));
						?>
							<?php #echo $form->errorSummary($model); ?>
							<div class="form-group">
								<?php echo $form->labelEx($model,'nombre'); ?> 
								<?php #echo $form->textField($model,'nombre',array('class'=>'form-control','maxlength'=>50)); ?>

									<?php 
									 $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
								    'id'=>'nombre',
									'name'=>'nombre',
									'value'=>$model->nombre,
								    'source'=>$this->createUrl('Producto/autocompleteVer'),
									'htmlOptions'=>array(
								          'size'=>100,
										  'placeholder'=>'Introduzca el nombre del producto (debe incluir la marca, el modelo y el color si aplica)',
										  'class'=>'form-control',
								          //'maxlength'=>45,
								        ),
								    // additional javascript options for the autocomplete plugin
								    'options'=>array(
								            'showAnim'=>'fold',
								    ),
									));?>
									<?php #echo $form->error($model,'nombre'); ?>
									<span class="help-block text_align_left padding_right">
		                    			<span class="help-block error" id="esconder" style="display: none;">Nombre ya existe
		                    			</span>
                    				</span>	
							</div>
							
							<div class="form-group">
								<?php echo $form->labelEx($model,'modelo'); ?> 
									<?php 
									 $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
								    'id'=>'modelo',
									'name'=>'modelo',
									'value'=>$model->modelo,
								    'source'=>$this->createUrl('Producto/autocompleteModelo'),
									'htmlOptions'=>array(
								          'size'=>100,
										  'placeholder'=>'Introduzca el nombre del modelo',
										  'class'=>'form-control',
								          //'maxlength'=>45,
								        ),
								    // additional javascript options for the autocomplete plugin
								    'options'=>array(
								            'showAnim'=>'fold',
								    ),
									));?>
									<?php #echo $form->error($model,'modelo'); ?>
									<span class="help-block text_align_left padding_right">
		                    			<span class="help-block error" id="esconderModelo" style="display: none;">Nombre del modelo no puede ser vacio
		                    			</span>
                    				</span>	
							</div>
							<div class="form-group">
                                <?php echo $form->labelEx($model,'padre_id'); 
		
								     $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
								    'id'=>'padre_id',
									'name'=>'padre_id',
									'value'=>$model->padre->nombre,
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
									<?php #echo $form->error($model,'padre_id'); ?>
									<span class="help-block text_align_left padding_right" >
		                    			<span class="help-block error" id="errorUrl" style="display: none;">Nombre del Producto padre no existe
		                    			</span>

							
								

							</div>

							<div class="form-group">
								 <label>Marca<span class="required">*</span></label>
                                <?php 
		
								     $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
								    'id'=>'marca',
									'name'=>'marca',
									'value'=>$model->padre->idMarca->nombre,
								    'source'=>$this->createUrl('Marca/autocomplete'),
									'htmlOptions'=>array(
								          'size'=>100,
										  'placeholder'=>'Introduzca la marca',
										  'class'=>'form-control',
								          //'maxlength'=>45,
								        ),
								    // additional javascript options for the autocomplete plugin
								    'options'=>array(
								            'showAnim'=>'fold',
								    ),
									));
									?>
									<?php #echo $form->error($model,'padre_id'); ?>
									<span class="help-block text_align_left padding_right" >
		                    			<span class="help-block error" id="esconderMarca" style="display: none;">Nombre de la marca no existe
		                    			</span>

							
								

							</div>


							     <div class="margin_top_small">
								    <label>Categoria<span class="required">*</span></label>
								    <select id="categoria" class="form-control">
								        <option value="">Seleccione una Categoría</option>
								<?php 


								    foreach($categorias as $categoria)
								    {
								    	
								    	if($categoria->id==$CategoriaSuperPadre)
								    	{ ?>
								    		<option selected="selected" value="<?php echo $categoria->id ?>"><?php echo $categoria->nombre;?></option> 
								    	<?php
								    	}
								    	else
								    	{?>
								    		<option value="<?php echo $categoria->id ?>"><?php echo $categoria->nombre;?></option> 
								    	<?php
								    	}

									} ?>


								</select>
								<span class="help-inline error hide" id="categoria_em" style="">Debe elegir una categoria</span>
								</div>
								<div class="margin_top_small">   
								<label>Subcategoria<span class="required">*</span></label>
								<select class="form-control comunes" id="subcategoria" name="ProductoPadre[id_categoria]"> 
								    <option value=''>Seleccione una Subcategoria</option>  
								    <option value='<?php echo $subCategoria;?>' selected="selected"><?php echo Categoria::model()->findByPk($subCategoria)->nombre;?></option> 
								</select>
								<span class="help-inline error hide" id="categoria_em" style="">Debe elegir una subcategoria</span>
								<input type="hidden" id="subs" name="subs" value="">
								</div>
											
							
							<div class="form-group">
								<label>UPC</label>
								<?php echo $form->textField($model,'upc',array('placeholder'=>'El codigo UPC debe contener 12 digitos','class'=>'form-control','maxlength'=>50)); ?>
								<?php echo $form->error($model,'upc'); ?>
							</div>
							
							
							<div class="form-group">
								<label>EAN</label>
								<?php echo $form->textField($model,'ean',array('placeholder'=>'El codigo EAN debe contener 13 digitos','class'=>'form-control','maxlength'=>50)); ?>
								<?php echo $form->error($model,'ean'); ?>
							</div>
							
							<div class="form-group">
								<label>GTIN</label>
								<?php echo $form->textField($model,'gtin',array('placeholder'=>'El codigo GTIN debe contener minimo 8 y maximo 14 digitos','class'=>'form-control','maxlength'=>50)); ?>
								<?php echo $form->error($model,'gtin'); ?>
							</div>
							
							<div class="form-group">
								<label>Numero de parte del Fabricante</label>
								<?php echo $form->textField($model,'nparte',array('class'=>'form-control','maxlength'=>50)); ?>
								<?php echo $form->error($model,'nparte'); ?>
							</div>
							
							<div class="form-group">
								<label>Color</label>
								<?php echo $form->textField($model,'color',array('class'=>'form-control','maxlength'=>50)); ?>
								<?php echo $form->error($model,'color'); ?>
							</div>
							
							<div class="form-group">
								<?php echo $form->labelEx($model,'color_id'); ?> 
								<?php echo $form->dropDownList($model,'color_id', CHtml::listData(Color::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'),array('id'=>'color_id','class'=>'form-control','empty'=>'Seleccione un Color')); ?>
								<span class="help-block text_align_left padding_right" >
		                    			<span class="help-block error" id="esconderColor" style="display: none;">Color no puede ser vacio
		                    			</span>
                    				</span>	
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




	<script>

	
$(document).ready(function() {
	 $('#esconder').hide();
	 $('#subs').val('<?php echo $subCategoria;?>');

	 var nameIni='<?php echo $nombreProducto?>';
	
	$('#button_send').click(function(){
		if(($('#categoria').val()=="" || $('#subcategoria').val()=="" || $('#nombre').val()=="" || $('#padre_id').val()=="" || $('#modelo').val()=="" || $('#color_id').val()=="" || $('#marca').val()==""))
		{
			if($('#padre_id').val()=="")
			{
				$('#errorUrl').text('Nombre del producto padre no puede ser vacio');
				$('#errorUrl').show();
			}
			if($('#nombre').val()=="")
			{
				$('#esconder').text('Nombre del producto no puede ser vacio');
				$('#esconder').show();
			}
			if($('#modelo').val()=="")
			{
				$('#esconderModelo').text('Nombre del modelo no puede ser vacio');
				$('#esconderModelo').show();
			}
			if($('#color_id').val()=="")
			{
				$('#esconderColor').text('Nombre del color no puede ser vacio');
				$('#esconderColor').show();
			}
			if($('#marca').val()=="")
			{
				$('#esconderMarca').text('Nombre de la Marca no puede ser vacio');
				$('#esconderMarca').show();
			}
			if($('#subcategoria').val()=="")
			{
          		 $('#subcategoria').addClass('error');
           		 $('#subcategoria'+'_em').removeClass('hide');
			}
			if($('#categoria').val()=="")
			{
          		 $('#categoria').addClass('error');
           		 $('#categoria'+'_em').removeClass('hide');
			}

			//categoria_em
			return false;
		}
		if($('#esconder').is(":visible") || $('#esconderMarca').is(":visible") || $('#esconderModelo').is(":visible") || $('#esconderColor').is(":visible") || $('#errorUrl').is(":visible") )
		{
			return false;
		} 

	});
	$('#padre_id').blur(function(){ 
		var nombre= $('#padre_id').val();
		if (nombre=="")
		{
			//$('#button_send').attr('disabled',true);
			$('#errorUrl').text('Nombre del producto padre no puede ser vacio');
			$('#errorUrl').show();
			$("#marca").prop('disabled', false);
			$("#categoria").prop('disabled', false);
			$("#subcategoria").prop('disabled', false);

		}
		else
		{	
			
			$.ajax({
		         url: "<?php echo Yii::app()->createUrl('producto/verificarTodaInformacion') ?>",
	             type: 'POST',
		         data:{
	                    nombre:nombre, nameIni:nameIni
	                   },
		        success: function (data) {
					
					if(data!='0')
					{
						var variables = data.split("//");
						

						if(variables[4]=="no")
						{
							$("#marca").prop('disabled', true);
							$("#subcategoria").prop('disabled', true);
							$("#categoria").prop('disabled', true);
						    $('#marca').val(variables[0]);
							$('#subcategoria').html(variables[1]);
							$('#categoria').html(variables[2]);
							$('#subs').val(variables[3]);
						}
						
					}
					else
					{
							$("#marca").prop('disabled', false);
							$("#subcategoria").prop('disabled', false);
							$("#categoria").prop('disabled', false);
					}
		       	}
		       })
		}
	});
	
	
	$('#nombre').blur(function(){ 
		var nombre= $('#nombre').val();
		if (nombre=="")
		{
			//$('#button_send').attr('disabled',true);
			$('#esconder').text('Nombre no puede ser vacio');
			$('#esconder').show();
			return false;
		}
		var id= <?php echo isset($model->id)?$model->id:"0";?>;
		$.ajax({
		         url: "<?php echo Yii::app()->createUrl('producto/verificarNombre') ?>",
	             type: 'POST',
		         data:{
	                    nombre:nombre,id:id
	                   },
		        success: function (data) {
					
					if(data==1)
					{
						// $('#button_send').attr('disabled',true);
						 $('#esconder').text('Nombre ya existe');
	        			 $('#esconder').show();
					}
					else
					{
						  $('#esconder').hide();
	       				  //$('#button_send').attr('disabled',false);
						 
					}
		       	}
		       })
	});

	$('#modelo').blur(function(){
		var nombre= $('#modelo').val();
		if (nombre=="")
		{
			//$('#button_send').attr('disabled',true);
			$('#esconderModelo').show();
		}
		else
		{
			//$('#button_send').attr('disabled',false);
			$('#esconderModelo').hide();	
		}

	});
	$('#color_id').change(function(){
		var nombre= $('#color_id').val();
		if (nombre=="")
		{
			//$('#button_send').attr('disabled',true);
			$('#esconderColor').show();
		}
		else
		{
			//$('#button_send').attr('disabled',false);
			$('#esconderColor').hide();
		}

	});
	$('#marca').blur(function(){
		var nombre= $('#marca').val();
		if (nombre=="")
		{
			//$('#button_send').attr('disabled',true);
			$('#esconderMarca').show();
		}
		else
		{
			//$('#button_send').attr('disabled',false);
			$('#esconderMarca').hide();
		}

	});

	$('#subcategoria').change( function(){
		 $('#subs').val($(this).val());
        if($(this).val() != '')
        {
          $('#subcategoria').removeClass('error');
          $('#subcategoria'+'_em').addClass('hide');
        }
        else
        {
            $('#subcategoria').addClass('error');
            $('#subcategoria'+'_em').removeClass('hide');
        }
    });

	$('#categoria').click( function(){
        if($(this).val() != ''){
          $('#categoria').removeClass('error');
          $('#categoria'+'_em').addClass('hide');
            var path = location.pathname.split('/');
            $.ajax({
                  url: "<?php echo Yii::app()->createUrl('producto/ultimasCategorias'); ?>",
                  type: "post",
                  dataType: "json",
                  data: { padre_id : $(this).val(), as_options: true },
                  success: function(data){
                       $('#subcategoria').html(data.options);
                       $('#subcategoria').removeAttr('disabled');
                      
                  },
            });
        }else{
            $('#subcategoria').html("<option value=''>Seleccione una Subcategoria</option>");
             $('#subcategoria').attr('disabled','disabled');
        }
    });
	
	
});	
		</script>
	
	
	
	
	
	

	
	
	
