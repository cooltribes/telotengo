<?php 
$this->breadcrumbs=array(
        'Productos'=>array('admin'),
        'Inventario',
    );?>
<div class="container">
	<div class="row-fluid">
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
							
							<?php /*<div class="form-group col-md-6 col-md-offset-3"> 
								<label>Numero de parte del fabricante</label>
								<?php echo $form->textField($model,'numFabricante',array('class'=>'form-control','maxlength'=>150)); ?>
								<?php echo $form->error($model,'numFabricante');  ?>
							</div> */?>
							
							<div class="form-group col-md-6 col-md-offset-3"> 
								<label>Condicion *</label>
								 <?php echo $form->dropDownList($model,'condicion',array('nuevo'=>'Nuevo', 'usado'=>'Usado', 'reformado'=>'Reformado'),array('id'=>'condicion','class'=>'form-control','empty'=>'Seleccione condicion')); ?>
								<?php echo $form->error($model,'condicion');  ?>
							</div>
							
							<div class="form-group col-md-6 col-md-offset-3" id='notaCondicion' style="display:none">
								<label>Nota de Condicion</label>
								<?php  echo $form->textArea($model,'notaCondicion',array('class'=>'form-control','maxlength'=>300)); ?>
								<?php echo $form->error($model,'notaCondicion'); ?>
							</div> 
							
							<div class="form-group col-md-6 col-md-offset-3"> 
								<label>Costo</label>
								<?php echo $form->textField($model,'costo',array('class'=>'form-control','maxlength'=>150, 'placeholder'=>'Precio a vender')); ?>
								<?php echo $form->error($model,'costo');  ?>
							</div>
							
							<div class="form-group col-md-6 col-md-offset-3"> 
								<label>Precio *</label>
								<?php echo $form->textField($model,'precio',array('class'=>'form-control','maxlength'=>150, 'placeholder'=>'Precio de costo')); ?>
								<?php echo $form->error($model,'precio');  ?>
							</div>
													
							
							<div class="form-group col-md-6 col-md-offset-3">
								<label>Cantidad a Vender *</label>
								<?php echo $form->textField($model,'cantidad',array('class'=>'form-control','maxlength'=>50)); ?>
								<?php echo $form->error($model,'cantidad'); ?>
							</div> 
							
							<div class="form-group col-md-6 col-md-offset-3">
								<label>Garantia</label>
								<?php  echo $form->textArea($model,'garantia',array('class'=>'form-control','maxlength'=>300)); ?>
								<?php echo $form->error($model,'garantia'); ?>
							</div> 
							
						<?php /*	<div class="form-group col-md-6 col-md-offset-3">
								<label>Metodo de envio</label>
								 <?php echo $form->dropDownList($model,'metodoEnvio',array('1'=>'Acordado con el cliente', '2'=>'A traves del servicio de TELOTENGO'),array('id'=>'metodo','class'=>'form-control','empty'=>'Seleccione metodo de envio')); ?>
								<?php echo $form->error($model,'metodoEnvio'); ?>
							</div> */ ?>
							
							<div class="form-group col-md-6 col-md-offset-3">
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
});	
	
</script>