<?php

class RecoveryController extends Controller
{
	public $defaultAction = 'recovery';
	
	/**
	 * Recovery password
	 */
	public function actionRecovery () {
	    //$this->layout='//layouts/b2b';
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
								$find->refresh();
								$empresas_id=EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$find->id))->empresas_id;
								if(!Bolsa::model()->findByAttributes(array('empresas_id'=>$empresas_id))) // si es primera vez que ingresa creele la bolsa
								{
									$bolsa= new Bolsa;
									$bolsa->empresas_id=$empresas_id;
									$bolsa->save();
								}
								/*Yii::app()->user->setFlash('success','Nueva contraseña guardada');
								$this->redirect('login');*/
								$model=new UserLogin;
								$model->username=$find->username;
								$model->password=$form2->password;
								if($model->validate()) 
									header('Location: '.Yii::app()->getBaseUrl(true));
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
                            $message->activarPlantillaMandrill();                   
                            $body=$this->renderPartial('//mail/mail_chngpsswd_request', array( 'activation_url'=>$activation_url ),true);             
                            $message->subject= 'Recuperación de contraseña';
                            $message->setBody($body,'text/html');                           
                            $message->addTo($user->email);
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