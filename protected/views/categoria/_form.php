
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
	<?php 
	if(isset($model->nombre))
	 	echo $form->hiddenField($model,'oculta',array('value'=>$model->id, 'id'=>'oculta')); 
	else	
	 	echo $form->hiddenField($model,'oculta',array('value'=>'', 'id'=>'oculta'));
	 	?>
	
	<div class="col-md-6 col-md-offset-3 margin_top_small">
		<?php echo $form->textFieldRow($model,'nombre',array('class'=>'form-control','maxlength'=>80, 'id'=>'nombre')); ?>
	</div>
	
	<div class="col-md-6 col-md-offset-3 margin_top_small">
		<label>Categoría padre </label>
	<?php


		//$list = CHtml::listData($models, 'id', 'nombre');
		$list=Categoria::model()->findAllByAttributes(array('id_padre'=>'0'), array('order' => 'nombre'));

		$cat = Categoria::model()->recursividad(0);
		
		
		echo CHtml::activeDropDownList($model,'id_padre', Categoria::model()->combinar($cat),
                               array('empty'=>'Si no posee Categorias, no seleccione',
                                'class'=>'form-control', 'id'=>'padre'));

		
	?>
	</div>
	
	<div class="col-md-6 col-md-offset-3 margin_top_small" id="ultimo">
		<label>Ultima Categoria</label> <br>
			<?php echo $form->radioButton($model,'ultimo',array('value'=>1,'uncheckValue'=>null, 'id'=>'ultimo1')); ?>
			<label for="si">Si</label>
			<?php echo $form->radioButton($model,'ultimo',array('value'=>0,'uncheckValue'=>null, 'id'=>'ultimo2')); ?>
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

		                <ul class="nav nav-stacked nav-tabs margin_top">
                   			 <li><a id="avanzar" style="cursor: pointer" title="Guardar y avanzar">Guardar y avanzar</a></li>
                		</ul>
	</div>
	
	
	</div>



<?php $this->endWidget(); ?>

<script>



	$('#avanzar').on('click', function(event) {
		
		event.preventDefault();
		
		var nombre=$("#nombre").val();
		var padre=$("#padre").val();
		var oculta=$("#oculta").val();
		var ultimo;
		
		 if($('#ultimo1').is(':checked')) 
		 	ultimo=$("#ultimo1").val();
		 else
		 	ultimo=$("#ultimo2").val();
		
		
		if(nombre!="")
		{
			$.ajax({
	         url: "<?php echo Yii::app()->createUrl('Categoria/crearAvanzar') ?>",
             type: 'POST',
	         data:{
                    nombre:nombre, padre:padre, ultimo:ultimo, oculta:oculta
                   },
	        success: function (data) {
	        	
      			window.location.href = '../categoria/categoriaRelacionada/'+data+'';
	       	}
	       })
		}
		

		}
	);

	/*
	$('#Categoria_destacado_0').click(function() {
		//alert('mostrar');
		
		$("#descripcion").css( "display", "block !important");
		$("#descripcion").show();		
	});	
	
	$('#Categoria_destacado_1').click(function() {
		//alert('esconder');
		$("#descripcion").hide();		
	});	*/
	
</script>
