<?php

class RecoveryController extends Controller
{
	public $defaultAction = 'recovery';
	
	/**
	 * Recovery password
	 */
	public function actionRecovery () {
	    
		$form = new UserRecoveryForm;
		if (Yii::app()->user->id) {
		    	$this->redirect(Yii::app()->controller->module->returnUrl);
		    } else {
				$email = ((isset($_GET['email']))?$_GET['email']:'');
				$activkey = ((isset($_GET['activkey']))?$_GET['activkey']:'');
				if ($email&&$activkey) {
					$form2 = new UserChangePassword;
		    		$find = User::model()->notsafe()->findByAttributes(array('email'=>$email));
		    		if(isset($find)&&$find->activkey==$activkey) {
			    		if(isset($_POST['UserChangePassword'])) {
							$form2->attributes=$_POST['UserChangePassword'];
							if($form2->validate()) {
								$find->password = Yii::app()->controller->module->encrypting($form2->password);
								$find->activkey=Yii::app()->controller->module->encrypting(microtime().$form2->password);
								$find->registro_password=1;
								if ($find->status==0) {
									$find->status = 1;
								}
								$find->save();
								Yii::app()->user->setFlash('success','Nueva contraseña guardada');
								$this->redirect('login');
							}
						} 
						$this->render('changepassword',array('form'=>$form2));
		    		} else {
		    			Yii::app()->user->setFlash('error','Enlace incorrecto');
						$this->redirect(Yii::app()->controller->module->recoveryUrl);
		    		}
		    	} else {
			    	if(isset($_POST['UserRecoveryForm'])) {
			    		$form->attributes=$_POST['UserRecoveryForm'];
			    		if($form->validate()){
			    			$user = User::model()->notsafe()->findbyPk($form->user_id);
							$activation_url = 'http://' . $_SERVER['HTTP_HOST'].$this->createUrl(implode(Yii::app()->controller->module->recoveryUrl),array("activkey" => $user->activkey, "email" => $user->email, 'solicitud'=>'recuperar'));
							
							$message = new YiiMailMessage;
							$message->view = 'mail_template';
							 
							//userModel is passed to the view
							$body=$this->renderPartial('//mail/mail_chngpsswd_request', array( 'activation_url'=>$activation_url ),true);
							$message->setSubject('Recuperación de contraseña');
							$message->setBody(array('body'=>$body,"undercomment"=>"¿No pediste restablecer tu contraseña? Si no pediste cambiar tu contraseña,
								es probable que otro usuario haya introducido tu nombre de usuario o dirección de correo electrónico por error al intentar restablecer su contraseña.
								Si ese es el caso, no es necesario tomar ninguna medida y puedes ignorar este mensaje."), 'text/html');
							$message->addTo($user->email);
							$message->from = array(Yii::app()->params['adminEmail'] => "Sigma Tiendas");
							Yii::app()->mail->send($message);

							Yii::app()->user->setFlash('success','Las instrucciones para la recuperación de la contraseña se han enviado a tu correo electrónico');
			    			$this->redirect(Yii::app()->getBaseUrl());
			    		}
			    	}
		    		$this->render('recovery',array('model'=>$form));
		    	}
		    }
	}

}