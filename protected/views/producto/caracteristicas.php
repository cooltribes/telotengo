<?php
$this->breadcrumbs=array(
	'Productos'=>array('Admin'),
	'Agregar',
);
?>

<div class="container-fluid" style="padding: 0 15px;">
	<div class="row">
		<!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
		<div class="col-md-10  col-md-push-2 main-content" role="main">
			<h1>Información General <small> - Registar nuevo producto</small></h1>
			<!-- Nav tabs -->
			<!-- SUBMENU ON -->
			<?php echo $this->renderPartial('_menu', array('model'=>$producto, 'activo'=>'caracteristicas')); ?>
			<!-- SUBMENU OFF -->

			<div class="well">
				<div class="row">
					<div class="col-md-6 1">
						<div class="form-group">
							<?php 
							if($producto->estado == 0){
								echo CHtml::link('+ Agregar característica', '#',array('class'=>'btn btn-default', 'id'=>'agregar_caracteristica'));
							}
							?>
						</div>
						<?php 
						$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
							'id'=>'caracteristica-form',
							'enableAjaxValidation'=>false,
							'htmlOptions'=>array('style'=>'display: none;', 'onsubmit'=>"return false;",),
						));
						?>
							<?php echo $form->errorSummary($model); ?>

							<div class="form-group">
								<label>Nombre</label>
								<?php echo $form->dropDownList($model,'caracteristica_id',CHtml::listData($caracteristicas,'id', 'nombre'),array('class'=>'form-control','empty' => 'Seleccione...')); ?>
							</div>
							<?php echo $form->hiddenField($model,'producto_id',array('value'=>$producto->id)); ?>
							<?php 
							/*echo CHtml::ajaxSubmitButton(
									'Agregar',
									$this->createUrl('agregarCaracteristica'),
									array('success'=>'console.log("fuck yeahh");'),
									array('class'=>'btn btn-primary btn-lg'),
								);*/
							$this->widget('bootstrap.widgets.TbButton', array(
								'buttonType'=>'ajaxSubmit',
								'url'=>$this->createUrl('agregarCaracteristica'),
								'htmlOptions'=>array('class'=>'btn btn-primary btn-lg'),
								'label'=>'Agregar',
								'ajaxOptions'=>array(
										'success'=>'js:function(data){
											$.fn.yiiListView.update("list-auth-caracteristicas",{});
											$("#caracteristica-form").hide("slow");
											$("#CaracteristicasProducto_nombre").val("");
										}',
									),
							)); 

							?>

						<?php $this->endWidget(); ?>
					</div>


				</div>
				<?php
			$template = '{summary}
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-hover">
				<tr>
				<th>Caracteristica</th>
				<th>Acción</th>
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
			));  

			?>
			</div>
			<?php
			$this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'link',
				'url'=>$this->createUrl('agregarInventario', array('producto_id'=>$producto->id)),
				'htmlOptions'=>array('class'=>'btn btn-info btn-lg'),
				'label'=>'Vender Producto',
			)); 
			?>
			
			<?php
			$this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'link',
				'url'=>$this->createUrl('admin'),
				'htmlOptions'=>array('class'=>'btn btn-success btn-lg'),
				'label'=>'Finalizar',
			)); 
			?>
			
		</div>

		<!-- COLUMNA PRINCIPAL DERECHA OFF // -->

	</div>
</div>

<script>
	function delete_caracteristica(id){
		$.ajax({
			url: "eliminarCaracteristica",
			type: "post",
			data: { id : id },
			success: function(html){
			   	$.fn.yiiListView.update("list-auth-caracteristicas",{});
			},
		});
	}

	$('#agregar_caracteristica').click(function(){
		$('#caracteristica-form').show('slow');
	});
</script>