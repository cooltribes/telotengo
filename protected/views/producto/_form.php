<div class="container">
	<div class="row-fluid">
		<!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
		<div>
			<h1>Información General <small> - Nuevo producto</small></h1>
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
							'enableAjaxValidation'=>false,
						));
						?>
							<?php echo $form->errorSummary($model); ?>
							<div class="form-group">
								<label>Nombre</label>
								<?php echo $form->textField($model,'nombre',array('class'=>'form-control','maxlength'=>150)); ?>
								<?php echo $form->error($model,'nombre'); ?>
							</div>
							<div class="form-group">
								<label>Modelo</label>
								<?php echo $form->textField($model,'modelo',array('class'=>'form-control','maxlength'=>150)); ?>
								<?php echo $form->error($model,'modelo');  ?>
							</div>
							
							<div class="form-group">
								<label>Referencia</label>
								<?php echo $form->textField($model,'codigo',array('class'=>'form-control','maxlength'=>50)); ?>
								<?php echo $form->error($model,'codigo'); ?>
							</div>
							
							<?php
							if(UserModule::isAdmin()){
							?>
								<div class="form-group">
								<?php echo $form->radioButtonListInlineRow($model,'estado', array(1 => 'Activo', 0 => 'Inactivo',)); ?>
								<?php echo $form->error($model,'estado'); ?>
								</div>
							<?php
							}
							?>

							<div class="form-group">
								<label>Peso estimado (Kg.)</label>
								<?php echo $form->textField($model,'peso',array('class'=>'form-control','placeholder'=>'Peso estimado del producto a registrar')); ?>
								<?php echo $form->error($model,'peso'); ?>
							</div>
							
							<div class="form-group">
								<label>Descripción</label>
								<?php $this->widget('ext.yiiredactor.widgets.redactorjs.Redactor', array( 'model' => $model, 'attribute' => 'descripcion' )); ?>
								<?php echo $form->error($model,'descripcion'); ?>
							</div>


							<div class="form-group">
								<label>Marcas</label>  
								<?php              
				                $models = Marca::model()->findAll(array('order' => 'id'));
								$list = CHtml::listData($models,'id', 'nombre'); 
								
								echo CHtml::dropDownList('Producto[marca_id]', $model->marca_id, $list, array('empty' => 'Seleccione...', 'class' => 'form-control')); 
								echo $form->error($model,'marca_id');

				                ?>
							</div>    

							<?php
							if(UserModule::isAdmin()){
							?>
								<div class="form-group">
								<?php echo $form->radioButtonListInlineRow($model, 'destacado', array(1 => 'Si', 0 => 'No',)); ?>
								<?php echo $form->error($model,'destacado'); ?>
								</div>
							<?php
							}
							?>
							
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
							<?php $this->widget('bootstrap.widgets.TbButton', array(
								'buttonType'=>'submit',
								'htmlOptions'=>array('class'=>'btn btn-primary margin_top_small col-md-3'),
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
	$('#Categoria_nombre').change(function(){
		//alert("cambio");
	});
	
	$('#cate_padre').change(function(){
		if($(this).val() != ''){
			var path = location.pathname.split('/');
			$.ajax({
			      url: "<?php echo Yii::app()->createUrl('producto/hijos'); ?>",
			      type: "post",
			      data: { categoria_id : $(this).val() },
			      success: function(data){
			           $('#cate_hijos').html(data);
			      },
			});
		}
	});
	
</script>