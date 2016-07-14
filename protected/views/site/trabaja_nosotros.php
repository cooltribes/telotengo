<div><strong><h3 style="font-weight: bold;">Trabaja con Nosotros</h3> </strong></div>
<hr class="no_margin_top">
<?php
	 if(Yii::app()->user->hasFlash('success')){?>
	    <div class="alert in alert-block fade alert-success text_align_center">
	        <?php echo Yii::app()->user->getFlash('success'); ?>
	    </div>
	<?php } ?>
	<?php if(Yii::app()->user->hasFlash('error')){?>
	    <div class="alert in alert-block fade alert-danger text_align_center">
	        <?php echo Yii::app()->user->getFlash('error'); ?>
	    </div>
	<?php } 
if(!isset($copy))
{ 
?>
<p style="text-align: justify;line-height: 23px;">
Telotengo ha sido creada por emprendedores venezolanos para crear una solución a las comunicaciones corporativas de las empresas en las acciones de compra venta de mercancía.
Si deseas unirte al equipo de Telotengo llena el siguiente formulario </p>

<p class="note alert">Todos los Campos son Requeridos.</p>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array( 
	'id'=>'empleo-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'type'=>'horizontal',
	'clientOptions'=>array(
		'validateOnSubmit'=>false,  
	),
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); ?>
	 
	<?php  #echo $form->errorSummary($model);?>
	 

	<div class="col-md-12 margin_top_small">
		<?php echo $form->textFieldRow($model,'nombre',array('class'=>'form-control','maxlength'=>80, 'id'=>'nombre')); ?>
		<?php echo $form->error($model,'nombre'); ?>

	</div>
	

	<div class="col-md-6 margin_top_small">
		<?php #echo $form->textFieldRow($model,'sexo',array('class'=>'form-control','maxlength'=>80, 'id'=>'sexo')); ?>
		        	<?php echo $form->dropDownListRow($model,'sexo', array("1" => "Masculino", "2" => "Femenino"), array('empty' => 'Seleccione sexo', 'class'=>'form-control','id'=>'sexo'));?> 
		<?php echo $form->error($model,'sexo'); ?>

	</div>

	<div class="col-md-6 margin_top_small">
		<?php echo $form->textFieldRow($model,'direccion',array('class'=>'form-control','maxlength'=>80, 'id'=>'direccion')); ?>
		<?php echo $form->error($model,'direccion'); ?>

	</div>

	<div class="col-md-6 margin_top_small">
		<?php echo $form->textFieldRow($model,'email',array('class'=>'form-control','maxlength'=>80, 'id'=>'email')); ?>
		<?php echo $form->error($model,'email'); ?>

	</div>

	<div class="col-md-6 margin_top_small">
		<?php #echo $form->textFieldRow($model,'fecha_nacimiento',array('class'=>'form-control','maxlength'=>80, 'id'=>'fecha_nacimiento')); ?>
		<label class="control-label">Fecha de nacimiento</label><span class="required">*</span>
		<input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento">
		<?php #echo $form->error($model,'fecha_nacimiento'); ?>
		 <span class="help-inline error hide" id="fecha_nacimiento_em">Debe elegir la fecha de nacimiento</span>

	</div>

	<div class="col-md-6 margin_top_small">
		<?php echo $form->textFieldRow($model,'lugar_nacimiento',array('class'=>'form-control','maxlength'=>80, 'id'=>'lugar_nacimiento')); ?>
		<?php echo $form->error($model,'lugar_nacimiento'); ?>

	</div>

	<div class="col-md-6 margin_top_small">
		<?php #echo $form->textFieldRow($model,'fecha_nacimiento',array('class'=>'form-control','maxlength'=>80, 'id'=>'fecha_nacimiento')); ?>
		<label class="control-label">CV</label><span class="required">*</span>
		<input name="fichero_usuario" type="file" id="cv"/>
		<?php #echo $form->error($model,'fecha_nacimiento'); ?>
		 <span class="help-inline error hide" id="cv_em">Debe elegir la fecha de nacimiento</span>

	</div>
	
	<div class="col-md-4 col-md-offset-4 margin_top">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
			'htmlOptions'=>array('class'=>'btn-block btn-orange btn btn-danger btn','id'=>'guardar')
		)); ?>
 
		              

                	
	</div>
	
	
	</div>



<?php $this->endWidget(); ?>

<script>
$(document).ready(function(){

	$('#guardar').on('click', function(event) {
		event.preventDefault();
		submitForm();

	});
});

 function submitForm(){
        var respuesta=0;
        var resp;  
        var submit = true;
        var field = "";      
        var array =new Array('#nombre','#cv','#sexo','#direccion','#email','#fecha_nacimiento', '#lugar_nacimiento');
        for(i=0; i<array.length; i++){
            resp=validate(array[i]);
            submit = resp[0];
            if(submit==false)
              respuesta=1;
            if(resp[1]!='')
                field = resp[1];
        }    
        if(respuesta==0){
            $('#empleo-form').submit();
        }            
        else{
            $(window).scrollTop($(field).position().top-100);    
        }
    }

        function validate(id){
        var submit = true;
        var field = id;
        if($(id).val()==''){
            submit=false;
            $(field).addClass('error');
            $(field+'_em').removeClass('hide');
            $(field+'_em').text('no puede estar vacio');
        }else
        {
          $(field).removeClass('error');
          if(!$(field+'_em').hasClass('hide'))
          {
              $(field+'_em').addClass('hide');
          }  

        field="";
        }
        
        return [submit,field];
    }

</script>


<?php 
}
?>