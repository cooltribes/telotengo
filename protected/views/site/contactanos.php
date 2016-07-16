<div><strong><h3 style="font-weight: bold;">CONTACTANOS</h3> </strong></div>
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
if(!isset($hide)):
?>
<p style="text-align: justify;line-height: 23px;">
Es posible que lo que quieras preguntar esté en nuestro apartado de Preguntas frecuentes. Si no está allí lo que buscas, llena este formulario y te contactaremos lo más pronto posible. ¡Gracias!</p>


<?php 
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'contact-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
	 
	<?php  #echo $form->errorSummary($model);?>
	 

	<div class="col-md-4 col-md-offset-4 margin_top_small">
		<?php echo $form->textFieldRow($model,'name', array('class'=>'form-control')); ?>

	</div>
	

	<div class="col-md-4 col-md-offset-4 margin_top_small">
	<?php echo $form->textFieldRow($model,'email', array('class'=>'form-control')); ?>

	</div>

	<div class="col-md-4 col-md-offset-4 margin_top_small">
			<?php echo $form->dropDownListRow($model, 'motivo', array(
			    'Solicitud de información'=>'Solicitud de información',
			    'Seguimiento del envío'=>'Seguimiento del envío',
			    'Información de pagos'=>'Información de pagos',
			    'Problemas con la mercancía'=>'Problemas con la mercancía',
			    'Devoluciones'=>'Devoluciones',
			    'Falla Técnica'=>'Falla Técnica',
			    'Asesoría de imagen' => 'Asesoría de imagen', 
			    'Otro'=>'Otro',
			), array(
			    'empty' => 'Seleccione',
			    'class'=>'form-control'
			));
		?>
	</div>

	<div class="col-md-4 col-md-offset-4 margin_top_small">
		<?php echo $form->textFieldRow($model,'subject',array('class'=>'form-control','size'=>60,'maxlength'=>128)); ?>
	</div>

	<div class="col-md-4 col-md-offset-4 margin_top_small">
		<?php echo $form->textAreaRow($model,'body',array('class'=>'form-control','rows'=>4, 'class'=>'span12')); ?>
	</div>


	<div class="col-md-4 col-md-offset-4 margin_top_small">
			<?php if(CCaptcha::checkRequirements()): ?>
			<?php echo $form->textFieldRow($model,'verifyCode', array('class'=>'form-control')); ?>
			<?php $this->widget('CCaptcha', array('imageOptions' => array('id' => 'yw0'),'showRefreshButton' => true,'buttonLabel' => 'Refrescar', 'buttonOptions' => '', 'buttonType' => 'button')); ?>
			<div class="hint">Por favor, introduzca las letras como se muestra. 
        <br/>Las letras no distinguen entre mayusculas y minusculas.</div>
        
		<?php echo $form->error($model,'verifyCode'); ?>
			
		
	
	<?php endif; ?>
			
	</div>
	<div class="col-md-4 col-md-offset-4 margin_top">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Enviar',
			'htmlOptions'=>array('class'=>'btn-block btn-orange btn btn-danger btn','id'=>'guardar')
		)); ?>
 
		              

                	
	</div>
	
	
	</div>



<?php $this->endWidget(); 
endif;
?>

<script>
$(document).ready(function(){

	/*$('#guardar').on('click', function(event) {
		event.preventDefault();
		submitForm();

	});*/
});

 function submitForm(){
        var respuesta=0;
        var resp;  
        var submit = true;
        var field = "";      
        var array =new Array('#nombre','#motivo','#mensaje','#asunto','#email');
        for(i=0; i<array.length; i++){
            resp=validate(array[i]);
            submit = resp[0];
            if(submit==false)
              respuesta=1;
            if(resp[1]!='')
                field = resp[1];
        }    
        if(respuesta==0){
            $('#contact-form').submit();
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


