
		<div class="row-fluid">


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'categoria-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'type'=>'horizontal',
	'clientOptions'=>array(
		'validateOnSubmit'=>true, 
	),
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); ?>
	
	<?php // echo $form->errorSummary($model); ?>
	
	<div class="col-md-6 col-md-offset-3 margin_top_small">
		<?php echo $form->textFieldRow($model,'nombre',array('class'=>'form-control','maxlength'=>80)); ?>
	</div>
	
	<div class="col-md-6 col-md-offset-3 margin_top_small">
		<label>Categoría padre </label>
	<?php


		//$list = CHtml::listData($models, 'id', 'nombre');
		$list=Categoria::model()->findAllByAttributes(array('id_padre'=>'0'), array('order' => 'nombre'));

		$cat = Categoria::model()->recursividad(0);
		
		
		echo CHtml::activeDropDownList($model,'id_padre', Categoria::model()->combinar($cat),
                               array('empty'=>'Si no posee Categorias, no seleccione',
                                'class'=>'form-control'));

		
	?>
	</div>
	
	<div class="col-md-6 col-md-offset-3 margin_top_small">
		<label>Ultima Categoria</label> <br>
			<?php echo $form->radioButton($model,'ultimo',array('value'=>1,'uncheckValue'=>null)); ?>
			<label for="si">Si</label>
			<?php echo $form->radioButton($model,'ultimo',array('value'=>0,'uncheckValue'=>null)); ?>
			<label for="no">No</label>
		
	</div>	
	
	<!--<div class="col-md-6 col-md-offset-3 margin_top_small">
	<?php echo $form->textFieldRow($model,'url_amigable',array('class'=>'form-control','maxlength'=>150)); ?>
	</div> -->
	
	<!--<div class="col-md-6 col-md-offset-3 lineRadios margin_top_small">
		<?php echo $form->radioButtonListInlineRow($model, 'destacado', array(1 => 'Si', 0 => 'No',)); ?>
	</div>-->
	
	<!--<div class="col-md-6 col-md-offset-3 margin_top_small" id="descripcion" <?php if($model->destacado==0) echo 'style="display: none;"'; ?>>
    	<label>Descripción </label>
			<?php // echo $form->textArea($model,'descripcion',array('class'=>'span5','maxlength'=>300)); ?>
			<?php $this->widget('ext.yiiredactor.widgets.redactorjs.Redactor', array(
				'editorOptions' => array( 
                	'imageUpload' => Yii::app()->createAbsoluteUrl('categoria/upload'),
                	'imageGetJson' => Yii::app()->createAbsoluteUrl('categoria/listimages')
                 	),
				'model' => $model, 'attribute' => 'descripcion' )); ?>
    </div>-->
	
	<?php // echo $form->textFieldRow($model,'imagen_url',array('class'=>'span5','maxlength'=>250)); ?>
	

		<?php 
			/*if($model->imagen_url != ""):?>
				<div class="col-md-6 col-md-offset-3 margin_top_small">
			<?php 	echo CHtml::image(Yii::app()->request->baseUrl.'/images/categoria/'.str_replace(".png","",$model->imagen_url).'_thumb.jpg',"image"); ?>
		
	</div>
	   <?php endif; */?>
	
	<!--<div class="col-md-6 col-md-offset-3 margin_top_small">
	    <label> Logotipo </label>
			<?php                       
			echo CHtml::activeFileField($model, 'imagen_url',array('name'=>'url'));
			echo $form->error($model, 'imagen_url'); 
			?>
    </div>-->
	
	<div class="col-md-6 col-md-offset-3 margin_top">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
			'htmlOptions'=>array('class'=>'form-control')
		)); ?>
	</div>
	
	
	</div>



<?php $this->endWidget(); ?>

<script>

	
	$('#Categoria_destacado_0').click(function() {
		//alert('mostrar');
		
		$("#descripcion").css( "display", "block !important");
		$("#descripcion").show();		
	});	
	
	$('#Categoria_destacado_1').click(function() {
		//alert('esconder');
		$("#descripcion").hide();		
	});	
	
</script>
