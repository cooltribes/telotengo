<div class="container">
	<div class="row-fluid">
		<!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
		<div>
			<h2>Inventario para : <small><?php echo $producto->nombre; ?></small></h2>
			<hr />
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
			<!-- SUBMENU ON -->
			<?php echo $this->renderPartial('_menu', array('model'=>$producto, 'activo'=>'inventario')); ?>
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
							<div class="form-group col-md-6 col-md-offset-3">
								<label>SKU</label>
								<?php echo $form->textField($model,'sku',array('class'=>'form-control','maxlength'=>150)); ?>
								<?php echo $form->error($model,'sku'); ?>
							</div>
							<div class="form-group col-md-6 col-md-offset-3"> 
								<label>Precio</label>
								<?php echo $form->textField($model,'precio',array('class'=>'form-control','maxlength'=>150)); ?>
								<?php echo $form->error($model,'precio');  ?>
							</div>
							
							<div class="form-group col-md-6 col-md-offset-3">
								<label>Cantidad a Vender</label>
								<?php echo $form->textField($model,'cantidad',array('class'=>'form-control','maxlength'=>50)); ?>
								<?php echo $form->error($model,'cantidad'); ?>
							</div> 

							<?php
								echo CHtml::hiddenField('Inventario[almacen_id]',14, array('id'=>'Inventario_almacen_id')); // id de almacen de Sigma
								echo CHtml::hiddenField('Inventario[producto_id]', $producto->id, array('id'=>'Inventario_producto_id'));
								echo CHtml::hiddenField('Inventario[precio_tienda]',1, array('id'=>'Inventario_precio_tienda'));
							?> 
                            <div class="form-group col-md-6 col-md-offset-3">
							<?php $this->widget('bootstrap.widgets.TbButton', array(
								'buttonType'=>'submit',
								'htmlOptions'=>array('class'=>'btn btn-primary margin_top_small form-control'),
								'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar',
							)); ?>
                            </div> 
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