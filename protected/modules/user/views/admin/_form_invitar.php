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
			<?php echo $form->labelEx($model,'email'); 
				 echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128, 'class'=>'form-control emails')); 
				 echo $form->error($model,'email'); 
		
			
			 ?>
			<!--<span class="help-block error" id="esconderEmail" style="display: none;">
		 </span> -->
		    <span class="help-block text_align_left padding_right">
		   		 <span class="help-block error" id="esconder" style="display: none;">Correo Electronico ya existe.
		   		 </span>
            </span>	
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-12">
			<?php echo $form->labelEx($model,'type'); ?>
			<?php echo $form->dropDownList($model,'type',User::itemAlias('UserType'),array('id'=>'User_type','class'=>'form-control','empty' => 'Seleccione una opción')); ?>
			<?php echo $form->error($model,'type'); ?>
		</div>
	</div>

	<?php
	if(Yii::app()->user->isAdmin())
	{
		$models = Empresas::model()->findAll(array('order'=>'razon_social asc'));
		
	}
	else 
	{
		$empresas_id=EmpresasHasUsers::model()->findByAttributes(array('users_id'=>Yii::app()->user->id))->empresas_id; // id del que esta intentado entrar
		$models = Empresas::model()->findAll('id="'.$empresas_id.'"');
	}

		$list = CHtml::listData($models, 'id', 'razon_social'); 


	?>
	
	<div id="miembroEmpresa" class="hide">
		<h3>Solo para el caso de invitar como miembro de empresa</h3>
		<div class="form-group">
		<div class="col-sm-12">
			<label>Empresa</label>
			<?php echo CHtml::dropDownList('empresas','',$list,array('id'=>'empresas','class'=>'form-control','disabled'=>'disabled')); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-12">
			<label>Cargo</label>
			<?php echo CHtml::dropDownList('cargo','',
				array(	'Dueño o Socio' => 'Dueño o Socio',
						'Junta Directiva' => 'Junta Directiva',
						'Gerente' => 'Gerente',
						'Empleado' => 'Empleado'),
				array('id'=>'cargo','class'=>'form-control','disabled'=>'disabled')); ?>
		</div>
	</div>
		
	</div>


	<div class="form-group">
	
		<div class="form-actions col-sm-offset-2 col-sm-10 no_margin botone">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				//'type'=>'primary',
				'label'=> 'Invitar',
				'htmlOptions'=>array('id'=>'guardar', 'class'=>'btn-orange orange_border white disabled')
			)); ?>
		</div> 

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	
$('#User_type').on('change', function() {
  //alert($(this).val()); 
  if($(this).val()==2){ // empresa
  	 //$('#miembroEmpresa').show();
  	 $("#miembroEmpresa").removeClass("hide");
  	 $('#empresas').prop('disabled', false);
  	 $('#cargo').prop('disabled', false);
  }else{
  	// $('#miembroEmpresa').hide();
  	 $("#miembroEmpresa").addClass("hide");
  	 $('#empresas').prop('disabled', 'disabled');
  	 $('#cargo').prop('disabled', 'disabled');
  }

});




</script>
<?php 
if(Yii::app()->user->isAdmin()): ?> 
			<script>
			$(document).ready(function() {
			$("#guardar").removeClass('disabled');

			});
			</script>
<?php 
endif;
if(!Yii::app()->user->isAdmin()) /// si no es usuario haga las validaciones, porque no estan funcionando con este layout
	{?>
		
	<script>
	
		$(document).ready(function() {
			$("#guardar").removeClass('disabled');
			$(".emails").on("focus blur release change focusout keyup", function(){
			//$('.emails').blur(function(){ 
				var email= $('.emails').val();
				if(email=="")
				{
					$('#esconder').empty();
					$('#esconder').append("Correo electronico vacio");
					 $('#esconder').show();	
					 $('#guardar').attr('disabled',true);
					 return false;
				}
				$.ajax({
				         url: "<?php echo Yii::app()->createUrl('user/admin/validarEmail') ?>",
			             type: 'POST',
			             dataType:"json",
				         data:{
			                    email:email, 
			                   },
				        success: function (data) {
							
							if(data=='1')
							{
								  $('#esconder').hide();
			       				  $('#guardar').attr('disabled',false);
							}
							else
							{
								$('#esconder').empty();
								if(data=='0')
								{
									$('#esconder').append("Correo electronico es repetido");	
								}
								 if(data=='2')
								 {
								 	$('#esconder').append("No es un correo electronico");	
								 }
								 
								 $('#guardar').attr('disabled',true);
			        			 $('#esconder').show();
							}
				       	}
				       })
			});
			$('.botone').click(function(event){ 
				var email= $('.emails').val();
				var usuario=$('#User_type').val();
				if(email=="")
				{
					$('#esconder').empty();
					$('#esconder').append("Correo electronico vacio");
					 $('#esconder').show();	
					 $('#guardar').attr('disabled',true);
					 return false;
				}
				if(usuario=="" || email=="")
				{
					alert('hay campos vacios');
					return false;
				}
						$.ajax({
				         url: "<?php echo Yii::app()->createUrl('user/admin/validarEmail') ?>",
			             type: 'POST',
			             dataType:"json",
				         data:{
			                    email:email, 
			                   },
				        success: function (data) {
							
							if(data=='1')
							{
								  $('#esconder').hide();
			       				  $('#guardar').attr('disabled',false);
							}
							else
							{
								$('#esconder').empty();
								if(data=='0')
								{
									$('#esconder').append("Correo electronico es repetido");	
								}
								 if(data=='2')
								 {
								 	$('#esconder').append("No es un correo electronico");	
								 }
								 
								 $('#guardar').attr('disabled',true);
			        			 $('#esconder').show();
							}
				       	}
				       })
				
				
				
					
			});
			
		});
		
	</script>
<?php		
	}


?>
