<style>
	.box{
		border: 1px solid black;
	}
	
</style>
<div class="container">
	<div class="row-fluid clearfix">
		<?php foreach($direcciones as $direcc):
			?>
			<div class="col-md-4 box">
				<p><?php echo $direcc->nombre;?></p>
				<p><?php echo $direcc->direccion_1;?></p>
				<p><?php echo $direcc->provincia->nombre;?></p>
				<p><?php echo $direcc->ciudad->nombre;?></p>
				<p><?php echo $direcc->telefono;?></p>
				<p> <input class="btn-green btn btn-danger btn-large margin_top_small" type="submit" id="<?php echo $direcc->id;?>" name="yt0" value="Enviar a esta direccion">
					</p>
			
				</div>
	
		<?php endforeach ; ?>
		<!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
	</div>
		<div>
			<h1>Agregar nueva direccion</h1>
			<!-- Nav tabs -->
			<!-- SUBMENU ON -->
			
			<!-- SUBMENU OFF -->

			<div class="well">
				<div class="row-fluid">
					<div>
						<?php 
						$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
							'id'=>'direccion-envio-form',
							'enableAjaxValidation'=>false,
							    'enableClientValidation'=>true,
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
								<label>Telefono</label>
								<?php echo $form->textField($model,'telefono',array('class'=>'form-control','maxlength'=>250)); ?>
								<?php echo $form->error($model,'telefono');  ?>
							</div>
							
							<div class="form-group">
								<label>Direccion</label>
								<?php echo $form->textField($model,'direccion_1',array('class'=>'form-control','maxlength'=>255)); ?>
								<?php echo $form->error($model,'direccion_1');  ?>
							</div>
							
							    <div class="form-group">
					       <label>Estado</label>
					        <?php echo $form->dropDownList($model,'provincia_id', CHtml::listData(Provincia::model()->findAll(),'id', 'nombre'), 
					        array(
					        'class'=>'form-control',
					        'empty'=>'Seleccione Estado',
					        'ajax'=>array(
					            'type'=>'POST',
					            'url'=>CController::createUrl('DireccionEnvio/selectdos'),
					            'update'=>'#'.CHtml::activeId($model, 'ciudad_id'),
					        ),
					         
					        )); ?>
					        <?php echo $form->error($model,'provincia_id'); ?>
					    </div>
					     
					    <div class="form-group">
					         <label>Ciudad</label>
					        <?php echo $form->dropDownList($model,'ciudad_id', array(), array('class'=>'form-control')); ?>
					        <?php echo $form->error($model,'ciudad_id'); ?>
					    </div>
							
							
							
							
						

						
							<?php $this->widget('bootstrap.widgets.TbButton', array(
								'buttonType'=>'submit',
								'id'=>'botone',
								'htmlOptions'=>array('class'=>'btn btn-primary margin_top_small form-control', 'id'=>'botone'),
								'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar',
							)); ?>

						<?php $this->endWidget(); ?>
					</div>


				</div>
			</div>
			<?php
			
			?>
		</div>

		<!-- COLUMNA PRINCIPAL DERECHA OFF // -->

	</div>
</div>
	<script>
	
$(document).ready(function() {
	 $('#esconder').hide();
	 var nombreRepetido=0;
	 var direccionRepetida=0;
	 var nombre="";
	 var direccion="";
	

		$('#nombre').blur(function(){
			var nombre=$(this).val();
			$.ajax({
			      url: "<?php echo Yii::app()->createUrl('direccionEnvio/buscarCiudadeRepetida'); ?>",
			      type: "post",
			      data: { nombre : nombre },
			      success: function(data){
			      	if(data==1)
			      	{
			      		$('#esconder').show();
			      		// $("#botone").attr("disabled", true);   
			      		 $("#botone").attr("disabled", "disabled");
			      		 
			      	}
			      	else
			      	{
			      		$('#esconder').hide();
			      		$("#botone").removeAttr("disabled");   
			      	}
			           
			      },
			});
	
		});
	


	
	
});	
		</script>
	
	
	
	
	