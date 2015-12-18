<div class="container">
	<div class="row-fluid">
		<!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
		<div>
			<h1>Caracteristicas<small> - <?php echo $model->nombre;?></small></h1>
			<!-- Nav tabs -->
			<!-- SUBMENU ON -->
			<?php echo $this->renderPartial('_menu', array('model'=>$model, 'activo'=>'caracteristicas')); ?>
			<!-- SUBMENU OFF -->

			<div class="well">
				<div class="row-fluid">
					<div>
						<?php 
						$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
							'id'=>'caracteristicas-form',
							
						));
						?>
							<?php echo $form->errorSummary($model); ?>
						
							<div class="form-group">
								<label>Caracteristica</label>
								<?php echo $form->textField($model,'caracteristica1' ,array('class'=>'form-control','maxlength'=>250)); ?>
								<?php echo $form->textField($model,'caracteristica2' ,array('class'=>'form-control','maxlength'=>250)); ?>
								<?php echo $form->textField($model,'caracteristica3' ,array('class'=>'form-control','maxlength'=>250)); ?>
								<?php echo $form->textField($model,'caracteristica4' ,array('class'=>'form-control','maxlength'=>250)); ?>
								<?php echo $form->textField($model,'caracteristica5' ,array('class'=>'form-control','maxlength'=>250)); ?>
							</div>
							<div class="form-group">
								<?php echo $form->labelEx($model,'descripcion'); ?> 
								<?php $this->widget('ext.yiiredactor.widgets.redactorjs.Redactor', array( 'model' => $model, 'attribute' => 'descripcion' )); ?>
								<?php echo $form->error($model,'descripcion'); ?>
							</div>
									

							</div>


							<?php $this->widget('bootstrap.widgets.TbButton', array(
								'buttonType'=>'submit',
								'htmlOptions'=>array('class'=>'btn btn-primary margin_top_small col-md-3', 'id'=>'button_send'),
								'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar',
							)); ?>

						<?php $this->endWidget(); ?>
					</div>


				</div>
			</div>	
		</div>

		<!-- COLUMNA PRINCIPAL DERECHA OFF // -->

	</div>
</div>