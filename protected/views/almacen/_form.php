


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'almacen-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>false,
	'type'=>'horizontal',
	'clientOptions'=>array(
		'validateOnSubmit'=>false,  
	),
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); ?>
	<?php echo $form->errorSummary($model); ?>
        
        
        


		<div class="form-group">
			<?php echo $form->dropDownList($model, 'provincia_id', CHtml::listData(Provincia::model()->findAll(array('order' => 'nombre')),'id', 'nombre'), array('empty' => 'Seleccione el estado donde se ubica', 'class' => 'form-control')); ?>
        </div>


		<div class="form-group">
			<?php 
			if(Yii::app()->controller->action->id == 'update'){
				echo $form->dropDownList($model, 'ciudad_id', CHtml::listData(Ciudad::model()->findAllByAttributes(array('provincia_id'=>$model->provincia_id), array('order' => 'nombre')),'id', 'nombre'), array('empty' => 'Seleccione la ciudad donde se ubica', 'class' => 'form-control')); 
			}else{
				echo $form->dropDownList($model, 'ciudad_id', array(), array('empty' => 'Seleccione un estado...', 'class' => 'form-control')); 
			}
			?>
        </div>


		<div class="form-group">
			<?php echo $form->textArea($model,'ubicacion',array('size'=>60,'maxlength'=>245,'class'=>'form-control', 'placeholder'=>'Indique la dirección de ubicación')); ?>
			<?php echo $form->error($model,'ubicacion'); ?>
		</div>
		
        <div class="form-group">
            <?php echo $form->textField($model,'nombre',array('class'=>'form-control','placeholder'=>'Indique el nombre de este almacén')); ?>
            <?php echo $form->error($model,'nombre'); ?>
        </div>

		<div class="form-group">
			<?php echo $form->textField($model,'alias',array('class'=>'form-control','placeholder'=>'Establezca un alias para este almacén')); ?>
			<?php echo $form->error($model,'alias'); ?>
		</div>
				
        <div class="form-group text-center">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'id'=>'botone',
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Registrar' : 'Guardar',
			'htmlOptions'=>array('class'=>' no-radius btn-orange white')
		)); ?>

<?php $this->endWidget(); ?>
        </div>


<script>
	/*$(document).ready(function(){
		if($('#Almacen_provincia_id').val() != ''){
			var path = location.pathname.split('/');
			$.ajax({
			      url: "<?php echo Yii::app()->createUrl('direccionEnvio/cargarCiudades'); ?>",
			      type: "post",
			      data: { provincia_id : $('#Almacen_provincia_id').val() },
			      success: function(data){
			           $('#Almacen_ciudad_id').html(data);
			           //$("#Almacen_ciudad_id option[value='"+$('#Almacen_ciudad_id').val()+"']").attr("selected", "selected");
			           console.log($('#Almacen_ciudad_id').val());
			      },
			});
		}
	});*/
$(document).ready(function(){
	
	$('#botone').click(function(){
		alert('asd');
		
	});
	
	$('#Almacen_provincia_id').change(function(){
		if($(this).val() != ''){
			var path = location.pathname.split('/');
			$.ajax({
			      url: "<?php echo Yii::app()->createUrl('direccionEnvio/cargarCiudades'); ?>",
			      type: "post",
			      data: { provincia_id : $(this).val() },
			      success: function(data){
			           $('#Almacen_ciudad_id').html(data);
			      },
			});
		}
		});
	});
</script>