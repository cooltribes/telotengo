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
			<?php echo $form->labelEx($model,'username'); ?>
			<?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'username'); ?>
		</div>
	</div>

	<!--<div class="form-group">
		<div class="col-sm-12">
			<?php echo $form->labelEx($model,'password'); ?>
			<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'password'); ?>
		</div>
	</div> -->

	<div class="form-group">
		<div class="col-sm-12">
			<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-12">
			<?php echo $form->labelEx($model,'status'); ?>
			<?php echo $form->dropDownList($model,'status',User::itemAlias('UserStatus'),array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	</div>

	<!--<div class="form-group">
		<div class="col-sm-12">
			<?php echo $form->labelEx($model,'type'); ?>
			<?php echo $form->dropDownList($model,'type',User::itemAlias('UserType'),array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'type'); ?>
		</div>
	</div>-->

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
					echo $form->dropDownList($profile,$field->varname,Profile::range($field->range),array('class'=>'form-control'));
				} elseif ($field->field_type=="TEXT") {
					echo CHtml::activeTextArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
				} else {
					if($field->varname != "fecha_nacimiento")
					{
						echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255), 'class'=>'form-control'));
					}		
					else
					{
						$model->fecha = date("d-m-Y", strtotime($model->profile->fecha_nacimiento));	
						#echo $form->textField($profile,$field->varname,array('value'=>$fecha,'size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255), 'class'=>'form-control','placeholder'=>'Ejemplo: 01-01-2000'));
						$this->widget('zii.widgets.jui.CJuiDatePicker',array(
					        'model' => $model,
					        'attribute' => 'fecha',
					        'language' => 'es',
					        'htmlOptions' => array('class'=>'form-control','placeholder'=>''), 
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

	<div class="form-group">
	
		<div class="form-actions col-sm-offset-2 col-sm-3 no_margin ">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
				'htmlOptions' => array('class'=>'btn form-control btn-orange orange_border white'), 
			)); ?>
		</div> 

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->