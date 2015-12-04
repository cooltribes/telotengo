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
             //$this->layout='//layouts/b2b';
			 
			 //colocar el formulario de login dentro de index
			 		if (Yii::app()->user->isGuest) {
			$modelado=new UserLogin;
			// collect user input data
			if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
            {
                echo UActiveForm::validate(array($modelado));
                Yii::app()->end();
            }
			if(isset($_POST['UserLogin']))
			{
				$modelado->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($modelado->validate()) {
					$this->lastViset();

					if(Yii::app()->user->isAdmin()){
						$this->redirect(Yii::app()->baseUrl);
					}else{
						
						 $rol=User::model()->buscarRol(Yii::app()->user->id);
						 $ruta= Yii::app()->createUrl('site/inhome2');
						 $this->redirect($ruta);
						/*if($rol=="vendedor")
						{
							$this->redirect(Yii::app()->user->returnUrl);
						}
						else 
						{
							$this->redirect(array('site/inhome2'));	
						}*/
						
						/*if (Yii::app()->user->returnUrl=='/index.php')
						{
							$this->redirect(Yii::app()->controller->module->returnUrl);
						}	
						else
						{
							$this->redirect(Yii::app()->user->returnUrl);
						}*/
							
					}
				}else{
				    $this->redirect(array('../','error'=>$model->errors));
				}
				
			}
			// display the login form
			//$this->render('/user/login',array('model'=>$modelado));
		} /*else
			$this->redirect(Yii::app()->controller->module->returnUrl);*/
			 
			 
			 
			 
			 
			 
			 
            
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
			{
				echo UActiveForm::validate(array($model,$profile));
				Yii::app()->end();
			}

		    if (Yii::app()->user->id) {
		    	if(Yii::app()->user->isAdmin())
				{
					$this->redirect(Yii::app()->createUrl('/user/profile/index'));
				}
				else 
				{
					$this->redirect(Yii::app()->createUrl('site/inhome2'));
				}
		    } else {
		    	if(isset($_POST['RegistrationForm'])) {
					$model->attributes=$_POST['RegistrationForm'];

					if(isset($model->email)){
						#Revisar si esta invitado en la base de datos
						$usuario = User::model()->findByAttributes(array('email'=>$model->email));
						Yii::app()->session['email']=$model->email;
						if(isset($usuario)){ #el usuario existe en la base de datos, tiene invitacion
							#revisar que tipo de invitacion tiene
							switch ($usuario->type){
								case User::TYPE_INVITADO_EMPRESA:
									# Flujo de cuando se invita a formar parte de una empresa
									Yii::app()->getSession()->add('invitadoempresa',$usuario->id);
									$this->redirect(Yii::app()->baseUrl.'/user/user/datos', array('email'=>$model->email));
									break;
								case User::TYPE_INVITADO_CLIENTE:
									#el usuario está invitado como cliente
									Yii::app()->getSession()->add('invitadocliente',$usuario->id);
									$this->redirect(Yii::app()->baseUrl.'/user/user/datos', array('email'=>$model->email));
									break;
								case User::TYPE_USUARIO_SOLICITA:
									#Usuario ya solicitó pero no recibió respuesta.
									Yii::app()->getSession()->add('usuario_solicitud',$usuario->id);
									$this->redirect(Yii::app()->baseUrl.'/user/user/respuesta', array('email'=>$model->email));
									break;
							}
						}
						else{
							#el usuario no esta y esta realizando una solicitud
							//Yii::app()->getSession()->add('usuarionuevo', $model->email);
							Yii::app()->session['usuarionuevo']=$model->email;
							$this->redirect(Yii::app()->baseUrl.'/user/user/datos');
						}	
					}
				}
			    $this->render('/user/registration',array('model'=>$model,'profile'=>$profile, 'modelado'=>$modelado));
		    }
	}


	public function lastViset() 
	{ //TODO misma funcion en el login
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}
     
    public function actionEmailExists(){
        $user=new User;
        $user->email=$_POST['email'];
        if($user->validate()){            
            if(isset($_POST['email'])){
                if(User::model()->findByAttributes(array('email'=>$_POST['email']))){
                    echo json_encode(array('status'=>'exists','message'=>'Su correo ya ha sido registrado en este sitio'));
                    
                }else{
                    echo json_encode(array('status'=>'ok'));                    
                }                    
            }
        }else{
            echo json_encode(array('status'=>'error','message'=>implode('<br/>',$user->errors['email'])));
        }
        
    }
    
	
}