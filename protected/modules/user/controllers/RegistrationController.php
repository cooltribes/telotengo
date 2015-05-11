<?php

class RegistrationController extends Controller
{
	public $defaultAction = 'registration';
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
	/**
	 * Registration user
	 */
	public function actionRegistration(){
            $model = new RegistrationForm;
            $profile = new Profile;
            $profile->regMode = true;
            
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
			{
				echo UActiveForm::validate(array($model,$profile));
				Yii::app()->end();
			}

		    if (Yii::app()->user->id) {
		    	$this->redirect(Yii::app()->controller->module->profileUrl);
		    } else {
		    	if(isset($_POST['RegistrationForm'])) {
					$model->attributes=$_POST['RegistrationForm'];

					if(isset($model->email)){
						#Revisar si esta invitado en la base de datos
						$usuario = User::model()->findByAttributes(array('email'=>$model->email));

						if(isset($usuario)){ #el usuario existe en la base de datos, tiene invitacion

							#revisar que tipo de invitacion tiene
							switch ($usuario->type) {
								case User::TYPE_INVITADO_EMPRESA:
									# code...
									break;
								case User::TYPE_INVITADO_CLIENTE:
									#code
									break;
								default:
									# code...
									break;
							}

						}
						else{
							#el usuario no esta y esta realizando una solicitud
							Yii::app()->getSession()->add('usuarionuevo', $model->email);
							$this->redirect(Yii::app()->baseUrl.'/user/user/datos');
						}	
					}
			
						#generar password
						


					$profile->attributes=((isset($_POST['Profile'])?$_POST['Profile']:array()));
					if($model->validate()&&$profile->validate())
					{
						$soucePassword = $model->password;
						$model->activkey=UserModule::encrypting(microtime().$model->password);
						$model->password=UserModule::encrypting($model->password);
						$model->verifyPassword=UserModule::encrypting($model->verifyPassword);
						$model->superuser=0;
						$model->type = 2; // usuario normal
						$model->status=((Yii::app()->controller->module->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);
						$model->username = $model->email;
						
						if (isset($_POST['facebook_id']) && $_POST['facebook_id']!="")
                            $model->facebook_id = $_POST['facebook_id'];
						
						if ($model->save()) {
							$profile->user_id=$model->id;
							$profile->save();
							if (Yii::app()->controller->module->sendActivationMail) {
								$activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model->activkey, "email" => $model->email));

								$message = new YiiMailMessage;
	                            $subject = 'Gracias por registrarte en Sigma Tiendas';                                
	                            $message->subject = $subject;
	                            $message->view = "mail_template";
	                            $body = '<h2>¡Bienvenido a Sigma Tiendas!</h2>
	                                Este correo electrónico indica el comienzo de tu registro en Sigmatiendas.com.
	                                <br/>Por favor valida tu cuenta haciendo clic en el enlace que aparece a continuación:

	                                <br/><br/><a href="'.$activation_url.'">Haz clic aquí para validar tu cuenta</a>';
	                            $message->from = array(Yii::app()->params['adminEmail'] => "Sigma Tiendas");
	                            $message->setBody(array("body"=>$body, "undercomment"=>"El siguiente paso es completar tu perfil, para que puedas realizar compras de manera más fácil y cómoda."),'text/html');              
	                            $message->addTo($model->email);

	                            Yii::app()->mail->send($message);
							}
							
							if ((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin) {
									$identity=new UserIdentity($model->username,$soucePassword);
									$identity->authenticate();
									Yii::app()->user->login($identity,0);

									$this->redirect(Yii::app()->baseUrl.'/user/profile/welcome');
							} else {
								if (!Yii::app()->controller->module->activeAfterRegister&&!Yii::app()->controller->module->sendActivationMail) {
									Yii::app()->user->setFlash('registration',UserModule::t("Gracias por registrarte. Por favor contacta a un administrador para activar tu cuenta."));
								} elseif(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false) {
									Yii::app()->user->setFlash('registration',UserModule::t("Gracias por registrarte. Por favor {{login}}.",array('{{login}}'=>CHtml::link(UserModule::t('Inicia sesión'),Yii::app()->controller->module->loginUrl))));
								} elseif(Yii::app()->controller->module->loginNotActiv) {
									Yii::app()->user->setFlash('registration',UserModule::t("Gracias por registrarte. Por favor revisa tu correo electrónico o inicia sesión."));
								} else {
									Yii::app()->user->setFlash('registration',UserModule::t("Gracias por registrarte. Por favor revisa tu correo electrónico."));
								}
								$this->refresh();
							}
						}
					} else $profile->validate();
				}
			    $this->render('/user/registration',array('model'=>$model,'profile'=>$profile));
		    }
	}

	
}