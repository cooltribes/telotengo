<?php 
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration");
$this->breadcrumbs=array(
	UserModule::t("Registration"),
);

//hay que borrar todas las variables de session
Yii::app()->session->clear();
Yii::app()->session->destroy();
?>

<div class="container">
	<div class="row-fluid">
		<h1>Forma parte de Telotengo.com</h1>
                <hr class="no_margin_top"/>
		<div class="col-sm-12">
			<?php 
			if(Yii::app()->user->hasFlash('registration')): ?>
				<div class="success">
					<?php echo Yii::app()->user->getFlash('registration'); ?>
				</div>
			<?php else: ?>
				
				<div class="row-fluid">
				    <div class="col-md-9 col-md-offset-3">
				        <div class="col-sm-9 no_padding" style="text-align: center">
                            <div class="margin_top margin_bottom">Ingresa tu correo electrónico</div>
                       </div>    
                        
    				<div class="form-horizontal" role="form">
    					<?php $form=$this->beginWidget('UActiveForm', array(
    						'id'=>'registration-form',
    						'enableAjaxValidation'=>true,
    						'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
    						'clientOptions'=>array(
    							'validateOnSubmit'=>true,
    							'validateOnChange'=>false,
    							'validateOnType'=>false,
    						),
    						'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'form-horizontal','role'=>"form"),
    					)); ?>

    						<?php
    							echo CHtml::hiddenField('facebook_id','');
    						?>
    						
    						<div class="form-group">
    						    <div class="col-sm-9">
    						    	<?php echo $form->emailField($model,'email', array('class'=>'form-control', 'placeholder'=>'Correo Electrónico')); ?>
    						    </div>
    						    <?php echo $form->error($model,'email'); ?>
    						</div>
    
    
    						<br/>
                                <?php echo CHtml::submitButton('Solicitar invitación', array('class'=>'btn btn-success btn-lg col-sm-9')); ?>    						
    
    					<?php $this->endWidget(); ?>
				</div>
				<div class="align_center col-sm-9 margin_top">
                  <small>Si ya tienes una cuenta <?php echo CHtml::link('haz click aquí', $this->createUrl('/user/login'), array()); ?></small>  
                </div>
				</div>

				</div><!-- form -->
			<?php endif; ?>
		</div>
	</div>
</div>
<script>
	
	$(document).ready(function(){
	    
	    window.fbAsyncInit = function() {
	        FB.init({
	            appId      : '430758747053394', // App ID secret 05cdfee72b8b07235643b07757120051
	            channelUrl : 'http://telotengo.com/site/user/registration', // Channel File
	            status     : true, // check login status
	            cookie     : true, // enable cookies to allow the server to access the session
	            xfbml      : true,  // parse XFBML 
	            oauth      : true
	        });

	    };
	    
	    (function(d){
	        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	        if (d.getElementById(id)) {return;}
	        js = d.createElement('script');js.id = id;js.async = true;
	        js.src = "//connect.facebook.net/en_US/all.js";
	        ref.parentNode.insertBefore(js, ref);
	    }(document));

		/*if ($('#Profile_birth').length>0) {
			if($('#Profile_birth').val() != ''){
				var array_fecha = $('#Profile_birth').val().split('-');
				$('#birth_day').val(array_fecha[2]);
				$('#birth_month').val(array_fecha[1]);
				$('#birth_year').val(array_fecha[0]);
			}
		}*/

		

		$('#birth_day').change(function(){
			if($('#birth_day').val()!=-1 && $('#birth_month').val()!=-1 && $('#birth_year').val()!=-1){
				if(!validar_fecha()){
					$('#birth_day').val('-1');
					$('#birth_month').val('-1');
					$('#birth_year').val('-1');
				}else{
					$('#Profile_fecha_nacimiento').val($('#birth_year').val()+'-'+$('#birth_month').val()+'-'+$('#birth_day').val());
				}
			}
		});

		$('#birth_month').change(function(){
			if($('#birth_day').val()!=-1 && $('#birth_month').val()!=-1 && $('#birth_year').val()!=-1){
				if(!validar_fecha()){
					$('#birth_day').val('-1');
					$('#birth_month').val('-1');
					$('#birth_year').val('-1');
				}else{
					$('#Profile_fecha_nacimiento').val($('#birth_year').val()+'-'+$('#birth_month').val()+'-'+$('#birth_day').val());
				}
			}
		});

		$('#birth_year').change(function(){
			if($('#birth_day').val()!=-1 && $('#birth_month').val()!=-1 && $('#birth_year').val()!=-1){
				if(!validar_fecha()){
					$('#birth_day').val('-1');
					$('#birth_month').val('-1');
					$('#birth_year').val('-1');
				}else{
					$('#Profile_fecha_nacimiento').val($('#birth_year').val()+'-'+$('#birth_month').val()+'-'+$('#birth_day').val());
				}
			}
		});
	});

	function check_fb(){
	    FB.getLoginStatus(function(response){
	        console.log("response: "+response.status);
	        if (response.status === 'connected') {
	        	// está conectado a facebook y además ya tiene permiso de usar la aplicacion personaling
					
				console.log('Welcome!  Fetching your information.... ');
	                    
	                    FB.api('/me', function(response) {
	                        console.log('Nombre: ' + response.id + '.\nE-mail: ' + response.email);
	                        console.log(response.birthday);
	                        console.log(response);
	                   
		     					$('#facebook_id').val(response.id);
		     					$('#RegistrationForm_email').val(response.email); 
		                        $('#Profile_first_name').val(response.first_name);
		                        $('#Profile_last_name').val(response.last_name);
		                        
		                        var fecha = response.birthday;
		                        var n = fecha.split("/"); // 0 mes, 1 dia, 2 año
		                        
		                        var a = n[2]+"-"+n[1]+"-"+n[0];
		                       	
		                        $('#birth_day').val(n[1]);
								$('#birth_month').val(n[0]);
								$('#birth_year').val(n[2]);    

		                        $('#Profile_fecha_nacimiento').val(a);
		                        
		                        if(response.gender == 'male')
		                        	$('#Profile_sexo_1').attr('checked',true);
		                        
		                        if(response.gender == 'female')
		                        	$('#Profile_sexo_0').attr('checked',true);

		                        $('#registration-form').submit();

	                    }, {scope: 'email,user_birthday'});
	        } else {
	            FB.login(function(response) {
	                if (response.authResponse) {
	                	//user is already logged in and connected (using information)
	                    console.log('Welcome!  Fetching your information.... ');
	                    
	                    FB.api('/me', function(response) {
	                        console.log('Nombre: ' + response.id + '.\nE-mail: ' + response.email);
							console.log(response.user_birthday);
							console.log(response);

							//$("#registration-form").fadeOut(100,function(){
		     					
		     					$('#facebook_id').val(response.id);
		     					$('#RegistrationForm_password').val('1234');
		     					$('#RegistrationForm_email').val(response.email); 
		                        $('#Profile_first_name').val(response.first_name);
		                        $('#Profile_last_name').val(response.last_name);
		                        
		                        var fecha = response.birthday;
		                        var n = fecha.split("/"); // 0 mes, 1 dia, 2 año
		                        
		                      	var a = n[2]+"-"+n[1]+"-"+n[0];
		                       
		                        $('#Profile_fecha_nacimiento').val(a);
		                        
		                        if(response.gender == 'male')
		                        	$('#Profile_sexo_1').attr('checked',true);
		                        
		                        if(response.gender == 'female')
		                        	$('#Profile_sexo_0').attr('checked',true);
		     		
	                    });
	                    
	                } else {
	                    console.log('User cancelled login or did not fully authorize.');
	                }
	            }, {scope: 'email,user_birthday'});
	        }
	    });
	}
    
    function validar_fecha(){
        var dia = $('#birth_day').val();
        var mes = $('#birth_month').val();
        var anio = $('#birth_year').val();
        var numDias = 31;
        
        //console.log('Dia: '+dia+' - Mes: '+mes+' - Año: '+anio);
        
        if(mes == 4 || mes == 6 || mes == 9 || mes == 11){
            numDias = 30;
        }
        
        if(mes == 2){
            if(comprobarSiBisisesto(anio)){
                numDias = 29;
            }else{
                numDias = 28;
            }
        }
        
        if(dia > numDias){
            //console.log('fecha invalida');
            return false;
        }
        return true;
    }
    
    function comprobarSiBisisesto(anio){
        if ( ( anio % 100 != 0) && ((anio % 4 == 0) || (anio % 400 == 0))) {
            return true;
        }
        else {
            return false;
        }
    }
</script>
