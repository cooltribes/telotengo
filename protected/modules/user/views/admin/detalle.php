<div class="container">
	<?php
	$this->breadcrumbs=array(
		'Solicitudes' => array('admin/solicitudes'),
		'Ver usuario',
	);
	?>
	<div class="row" id="usuario">
		<div class="col-md-offset-3 col-md-6">
			<h1><?php echo "Ver usuario"; ?></h1>
			<hr class="no_margin_top" />

			<div class="form-horizontal margin_top" role="form">

						<?php $form=$this->beginWidget('CActiveForm', array(
							'id'=>'user-form',
							'enableAjaxValidation'=>true,
							'htmlOptions' => array('enctype'=>'multipart/form-data'),
						));
						?>

							<?php echo $form->errorSummary(array($model,$profile)); ?>

							<div class="form-group">
								<div class="col-sm-12">
									<?php echo $form->labelEx($model,'email'); ?>
									<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'disabled'=>'disabled')); ?>
									<?php echo $form->error($model,'email'); ?>
								</div>
							</div>


							<?php 
								$profileFields=$profile->getFields();
								if ($profileFields) {
									foreach($profileFields as $field) {
									?>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo $form->labelEx($profile,$field->varname); ?>
										<?php 
										if ($widgetEdit = $field->widgetEdit($profile)) {
											echo $widgetEdit;
										} elseif ($field->range) {
											echo $form->dropDownList($profile,$field->varname,Profile::range($field->range),array('class'=>'form-control', 'disabled'=>'disabled'));
										} elseif ($field->field_type=="TEXT") {
											echo CHtml::activeTextArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
										} else {
											if($field->varname != "fecha_nacimiento")
											{
												echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255), 'class'=>'form-control', 'disabled'=>'disabled'));
											}		
											else
											{
												$model->fecha = date("d-m-Y", strtotime($model->profile->fecha_nacimiento));	
												#echo $form->textField($profile,$field->varname,array('value'=>$fecha,'size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255), 'class'=>'form-control','placeholder'=>'Ejemplo: 01-01-2000'));
												$this->widget('zii.widgets.jui.CJuiDatePicker',array(
											        'model' => $model,
											        'attribute' => 'fecha',
											        'language' => 'es',
											        'htmlOptions' => array('class'=>'form-control','placeholder'=>'', 'disabled'=>'disabled'), 
											        // additional javascript options for the date picker plugin
											        'options'=>array(
											            'showAnim'=>'fold',
											            'dateFormat'=>'dd-mm-yy',
											        ),
											    ));
											}	
										}
										 ?>
										<?php echo $form->error($profile,$field->varname); ?>
									</div>
								</div>
									<?php
									}
								}
							?>	
							<div class="col-md-3 col-md-offset-5 padding_right">
								<a href="#" id="siguiente" class="btn form-control btn-orange orange_border white" id="btn_search_event">Siguiente</a>
							</div>

							<div class="form-group">
							
								<div class="form-actions col-sm-offset-2 col-sm-10 no_margin hide">
									<?php $this->widget('bootstrap.widgets.TbButton', array(
										'buttonType'=>'submit',
										'type'=>'primary',
										'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
									)); ?>
								</div> 

							</div>

						<?php $this->endWidget(); ?>

						</div><!-- form -->




		</div>
	</div>

		<div class="row" id="empresa" style='display:none;'>
		<div class="col-md-offset-3 col-md-6">
			<h1><?php echo "Ver Empresa"; ?></h1>
			<hr class="no_margin_top" />

			<div class="form-horizontal margin_top" role="form">

							<?php $form=$this->beginWidget('CActiveForm', array(
							'id'=>'empresas-form',
							'enableAjaxValidation'=>true,
							'htmlOptions' => array('enctype'=>'multipart/form-data'),
						));
						?>

							<?php echo $form->errorSummary(array($empresas,$profile)); ?>

							<div class="form-group">
								<div class="col-sm-12">
									<?php echo $form->labelEx($empresas,'razon_social'); ?>
									<?php echo $form->textField($empresas,'razon_social',array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'disabled'=>'disabled')); ?>
									<?php echo $form->error($empresas,'razon_social'); ?>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<?php echo $form->labelEx($empresas,'sector'); ?>
										<?php echo CHtml::textField("sector", CHtml::encode( $empresas->itemAlias("Sector",$empresas->sector)) , array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'disabled'=>'disabled')); ?>
					
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<?php echo $form->labelEx($empresas,'rif'); ?>
									<?php echo $form->textField($empresas,'rif',array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'disabled'=>'disabled')); ?>
									<?php echo $form->error($empresas,'rif'); ?>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<?php echo $form->labelEx($empresas,'direccion'); ?>
									<?php echo $form->textArea($empresas,'direccion',array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'disabled'=>'disabled')); ?>
									<?php echo $form->error($empresas,'direccion'); ?>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<?php echo $form->labelEx($empresas,'tipo_contribuyente'); ?>
									<?php echo CHtml::textField("sector", CHtml::encode( $empresas->itemAlias("TipoContribuyente",$empresas->tipo_contribuyente)) , array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'disabled'=>'disabled')); ?>
								</div>
							</div>

							<?php if($empresas->telefono!=""):?>
							<div class="form-group">
								<div class="col-sm-12">
									<?php echo $form->labelEx($empresas,'telefono'); ?>
									<?php echo $form->textField($empresas,'telefono',array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'disabled'=>'disabled')); ?>
									<?php echo $form->error($empresas,'telefono'); ?>
								</div>
							</div>
						<?php endif;?>

							<div class="form-group">
								<div class="col-sm-12">
									<?php echo $form->labelEx($empresas,'estado'); ?>
									<?php echo CHtml::textField("provincia", Provincia::model()->findByPk($provincia)->nombre , array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'disabled'=>'disabled')); ?>
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-12">
									<?php echo $form->labelEx($empresas,'ciudad'); ?>
									<?php echo CHtml::textField("provincia", Ciudad::model()->findByPk($empresas->ciudad)->nombre , array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'disabled'=>'disabled')); ?>
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-12">
									<?php echo $form->labelEx($empresas, 'tipo de Empresa'); ?>
									<?php echo $form->textField($empresas,'rol',array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'disabled'=>'disabled')); ?>
									<?php echo $form->error($empresas,'rol'); ?>
								</div>
							</div>

							<div>
								<div class="col-md-3 col-md-offset-0 padding_right">
									<a href="#" id="anterior" class="btn-orange btn btn-danger orange_border" id="btn_search_event">anterior</a>
								</div>
								<div class="col-md-3 col-md-offset-5 padding_right">
									<a href="#" id="aprobar" class="btn-orange btn btn-danger orange_border" id="btn_search_event">Aprobar</a>
								</div>
							</div>

						<?php $this->endWidget(); ?>


			</div><!-- form -->




		</div>
	</div>

</div>


<script>
$(document).ready(function(){

	$('#siguiente').click(function(){
		$('#usuario').hide();
		$('#empresa').show();
	
	});

	$('#anterior').click(function(){
		$('#usuario').show();
		$('#empresa').hide();
	
	});

	$('#aprobar').click(function(){
		var id="<?php echo $model->id;?>";
		
			$.ajax({
	         url: "<?php echo Yii::app()->createUrl('user/user/activarDesactivar') ?>",
             type: 'POST',
	         data:{
                    id:id,
                   },
	        success: function (data) {
	        	window.location.href = '<?php echo Yii::app()->createUrl("user/admin/solicitudes");?>';	
	       	}
	       })
		});

});
</script>