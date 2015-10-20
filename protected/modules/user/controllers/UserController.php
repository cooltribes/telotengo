<?php

class UserController extends Controller
{
	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','datos','respuesta', 'setPassword', 'borrar'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('tucuenta','favoritos','quitarfav','usuariostienda','createuser','deleteuser','editrol','avatar',
								'agregarsocial','deletesocial','privacidad','notificaciones','enviarbolsa', 'activarDesactivar'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}	

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$model = $this->loadModel();
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/*
	Action para el finalizar la solicitud con respuesta adecuada
	*/
	public function actionRespuesta(){
		$this->layout='//layouts/b2b';
		$user = User::model()->findByPk(Yii::app()->session['usuario_solicitud']);
		$empresasHasUsers = EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$user->id));
		$empresa = $empresasHasUsers->empresas; 

		if(isset($_POST['Empresas']['comentario'])){
			 if($_POST['Empresas']['comentario'] == ""){
			 	Yii::app()->user->setFlash('error',"Tu comentario no se puede enviar vacío.");
			 	$this->render('respuesta',array('user'=>$user,'empresa'=>$empresa));
			 }else{
			 	$empresa->saveAttributes(array('comentario'=>$_POST['Empresas']['comentario']));

			 	#enviar mail a admin
			 	$message = new YiiMailMessage;
                $subject = 'El usuario '.$user->email.' agregó un comentario en su solicitud.';                                
                $message->subject = $subject;
                $message->view = "mail_template";
                $body = 'El usuario '.$user->email.' agregó un comentario en su solicitud de empresas.
                    <br/><br/>Comentario:<br/>
                    '.$empresa->comentario.'
                    <br/><br/>El usuario se encuentra en la espera de respuesta.';
                $message->from = array(Yii::app()->params['adminEmail'] => "Sigma Tiendas");
                $message->setBody(array("body"=>$body),'text/html');              
                $message->addTo(Yii::app()->params['contacto']);
                Yii::app()->mail->send($message);

				Yii::app()->user->setFlash('success',"El comentario fue enviado correctamente. En las próximas horas tendrás respuesta.");
			 	$this->redirect(Yii::app()->getBaseUrl(true));
			 }
		}else{
			$this->render('respuesta',array('user'=>$user,'empresa'=>$empresa));
		}
	}
	
	/**
	 * Tu cuenta
	 */
	public function actionTucuenta($img = 0)
	{
		$model = User::model()->findByPk(Yii::app()->user->id);
        
        if(isset($_POST['url']))
        {
            if(!is_dir(Yii::getPathOfAlias('webroot').'/images/user/'))
            {
                mkdir(Yii::getPathOfAlias('webroot').'/images/user/',0777,true);
            }
            
                $rnd = rand(0,9999);  
                $images=CUploadedFile::getInstanceByName('url');

                if (isset($images) && count($images) > 0) {
                    $model->avatar_url = "{$rnd}-{$images}";
                    $model->save();
                    
                    $nombre = Yii::getPathOfAlias('webroot').'/images/user/'.$model->id;
                    $extension_ori = ".jpg";
                    $extension = '.'.$images->extensionName;
                   
                    if ($images->saveAs($nombre . $extension)) {
            
                        $model->avatar_url = '/images/user/'.$model->id .$extension;
                        $model->save();
                                        
                        Yii::app()->user->setFlash('success',"Avatar modificado exitosamente.");
    
                        $image = Yii::app()->image->load($nombre.$extension);
                        $image->resize(270, 270);
                        $image->save($nombre.'_thumb'.$extension);

                        # enviar correo por perfil completo
                        $porcentaje = $model->profile->isAllPercentage();

		                if($porcentaje && $model->perfil_completo==0){
		                	$model->perfil_completo = 1;
		                	if($model->save()){
		                		# Sumar 500 bs al balance
		                		$balance = new Balance;
		                		$balance->total = 500;
		                		$balance->orden_id = 0;
		                		$balance->user_id = $model->id;
		                		$balance->tipo = 5;
		                		$balance->save();
		                		Yii::app()->user->setFlash('success', 'Avatar modificado exitosamente. Además hemos sumado 500 Bs a tu saldo.');
		               			$model->mailCompletarPerfil(); // correo por completar perfil
		               		}
		                }

                    }
                    else {
                        $marca->delete();
                    }
                    
                }else{
                    if($model->save()){
                        Yii::app()->user->setFlash('success',"Avatar modificado  exitosamente.");
                      
                        
                    }else{
                        Yii::app()->user->setFlash('error',"Avatar no pudo ser modificado.");
                        
                    }
                }// isset

        }
		
		$empresas = new EmpresasHasUsers;
		$empresas->users_id = $model->id;
		
		$redes = new Redes;
		$redes->users_id = $model->id;
		 
		$provider = $redes->search();
		
		$dataProvider = $empresas->search();
		$productos=Producto::model()->getSuggestions($model->id,6); 
		$this->render('tu_cuenta',array('model'=>$model,'dataProvider'=>$dataProvider,'provider'=>$provider,'productos'=>$productos));
	}

	public function actionFavoritos(){
		$model = new UserFavoritos;
		$model->user_id = Yii::app()->user->id;

		$dataProvider = $model->search();

		$this->render('favoritos',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/*
	Action para quitar un producto de favorito
	*/
	public function actionQuitarFav($producto_id,$user_id){
		$model = UserFavoritos::model()->findByAttributes(array('producto_id'=>$producto_id,'user_id'=>$user_id));
		$model->delete();

		Yii::app()->user->setFlash('success', 'Producto eliminado de los favoritos.');

		$this->redirect(array('favoritos')); 
	}

	/*
	Action para pasar un producto de favorito a la bolsa
	*/
	public function actionEnviarbolsa($producto_id,$user_id){
		// Busqueda del producto favorito del usuario
		$model = UserFavoritos::model()->findByAttributes(array('producto_id'=>$producto_id,'user_id'=>$user_id));

		$user = Yii::app()->user->id;
		$bolsa = Bolsa::model()->findByAttributes(array('users_id'=>$user_id));
		$inventario = Inventario::model()->findByAttributes(array('producto_id'=>$producto_id));

		// si el usuario tiene un carrito creado se agrega
		if(isset($bolsa)){

			if(!$bolsa->isProductAlready($inventario->id)){ // el producto no está en la bolsa
				$ag = new BolsaHasInventario; 
				$ag->bolsa_id = $bolsa->id;
				$ag->inventario_id = $inventario->id;
				$ag->cantidad = 1;

				if($ag->save()){
					Yii::app()->user->setFlash('success', 'Se ha agregado correctamente el producto a la bolsa.');
				}else{
					Yii::trace('Favorito a Bolsa: '.$wishlisthas->id.' Error al pasar :'.print_r($detalle->getErrors(),true), 'Fav a Bolsa');
					Yii::app()->user->setFlash('error', 'Error al agregar.');
				}	
			}
			else{ // ya estaba el producto, es solo sumarle uno a la cantidad
				$bolsaHas = BolsaHasInventario::model()->findByAttributes(array('bolsa_id'=>$bolsa->id,'inventario_id'=>$inventario->id));
				$cantidad = $bolsaHas->cantidad + 1;
				$bolsaHas->saveAttributes(array('cantidad'=>$cantidad));

				Yii::app()->user->setFlash('success', 'Se ha agregado correctamente el producto a la bolsa.');
			}			
		} 
		else{ // no tenia carrito aún
			$nueva = new Bolsa;
			$nueva->users_id = $user;
			$nueva->save();
			
			$ag = new BolsaHasInventario;
			$ag->bolsa_id = $nueva->id;
			$ag->inventario_id = $inventario->id; 
			$ag->cantidad = 1;
			
			if($ag->save()){
				Yii::app()->user->setFlash('success', 'Se ha agregado correctamente el producto a la bolsa.');
			}else{
				Yii::trace('Fav a Bolsa: '.$wishlisthas->id.' Error al pasar :'.print_r($detalle->getErrors(),true), 'Fav a Bolsa');
				Yii::app()->user->setFlash('error', 'Error al agregar.');
			}
							
		}

		$model->delete();
		// redireccion al carrito de compras con mensaje de aprobación
		$this->redirect(array('/bolsa/view'));
	}
	
	public function actionAgregarSocial(){
			
		$model = new Redes();
		
		if(isset($_POST['Redes'])){
			
			$user = User::model()->findByPk(Yii::app()->user->id);
			$profile = $user->profile;
			$model->users_id = $user->id;
			
            $model->attributes=$_POST['Redes'];
            if($model->save()){
                Yii::app()->user->setFlash('success', 'Datos guardados con éxito');
                $porcentaje = $user->profile->isAllPercentage();

                if($porcentaje && ($user->perfil_completo==0)){
                	$user->perfil_completo = 1;
                	if($user->save()){
                		# Sumar 500 bs al balance
                		$balance = new Balance;
                		$balance->total = 500;
                		$balance->orden_id = 0;
                		$balance->user_id = $user->id;
                		$balance->tipo = 5;
                		$balance->save();
                		Yii::app()->user->setFlash('success', 'Datos guardados con éxito. Además hemos sumado 500 Bs a tu saldo.');
               			$user->mailCompletarPerfil(); // correo por completar perfil
               		}
                }

            }else{
            	Yii::app()->user->setFlash('error','Error al guardar los datos');
            }
            $this->redirect(array('tucuenta'));
        }

		$this->render('agregar_dato',array(
			'model'=>$model,
		));
	}	

	public function actionPrivacidad(){
			
		$model = Privacidad::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
		$user = User::model()->findByPk(Yii::app()->user->id);
		if(!$model){
			$model = new Privacidad();
			$model->user_id = $user->id;
		}
		
        if(isset($_POST['Privacidad'])){
            $model->attributes=$_POST['Privacidad'];
            if($model->save()){
                Yii::app()->user->setFlash('success', 'Datos guardados');
            }else{
            	Yii::app()->user->setFlash('error','Error al guardar');
            }
            $this->redirect(array('tucuenta'));
        }

		$this->render('privacidad',array(
			'model'=>$model,
			'user'=>$user,
		));
	}

	public function actionNotificaciones(){
			
		$model = Notificaciones::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
		$user = User::model()->findByPk(Yii::app()->user->id);
		if(!$model){
			$model = new Notificaciones();
			$model->user_id = $user->id;
		}
		
        if(isset($_POST['Notificaciones'])){
            $model->attributes=$_POST['Notificaciones'];
            if($model->save()){
                Yii::app()->user->setFlash('success', 'Datos guardados');
            }else{
            	Yii::app()->user->setFlash('error','Error al guardar');
            }
            $this->redirect(array('tucuenta'));
        }

		$this->render('notificaciones',array(
			'model'=>$model,
			'user'=>$user,
		));
	}
	
	/**
	 * Avatar
	 */
	public function actionAvatar()
	{
		$model = User::model()->findByPk(Yii::app()->user->id);
		
		if(isset($_POST['url']))
		{
			if(!is_dir(Yii::getPathOfAlias('webroot').'/images/user/'))
			{
	   			mkdir(Yii::getPathOfAlias('webroot').'/images/user/',0777,true);
	 		}
			
				$rnd = rand(0,9999);  
				$images=CUploadedFile::getInstanceByName('url');

				if (isset($images) && count($images) > 0) {
					$model->avatar_url = "{$rnd}-{$images}";
					$model->save();
			        
			        $nombre = Yii::getPathOfAlias('webroot').'/images/user/'.$model->id;
			        $extension_ori = ".jpg";
					$extension = '.'.$images->extensionName;
			       
			       	if ($images->saveAs($nombre . $extension)) {
			
			       		$model->avatar_url = '/images/user/'.$model->id .$extension;
			            $model->save();
										
						Yii::app()->user->setFlash('success',"Avatar modificado exitosamente.");
	
						$image = Yii::app()->image->load($nombre.$extension);
						$image->resize(270, 270);
						$image->save($nombre.'_thumb'.$extension);					
					}
					else {
			        	$marca->delete();
					}
			        
				}else{
			    	if($model->save()){
			        	Yii::app()->user->setFlash('success',"Avatar modificado  exitosamente.");
			        }else{
			        	Yii::app()->user->setFlash('error',"Avatar no pudo ser modificado.");
			        }
				}// isset

		}
			
		$this->render('avatar',array('model'=>$model));
	}
	
	/**
	 * Crear usuario para la tienda actual
	 */
	public function actionCreateuser()
	{
		$model = new RegistrationForm;
        $profile = new Profile;
		
		$usuario = User::model()->findByPk(Yii::app()->user->id);
		$empresashas = EmpresasHasUsers::model()->findAllByAttributes(array('users_id'=>$usuario->id,));
		
		$empresas = Array();
		
		foreach($empresashas as $each){
			$empresa = Empresas::model()->findByPk($each->empresas_id);
			
			if($empresa->tipo==2)
				$empresas[] = $empresa;
		}
		
		$list = CHtml::listData($empresas, 'id', 'razon_social');    
		
		if(isset($_POST['RegistrationForm'])) {
				
			$model->attributes=$_POST['RegistrationForm'];
			
			$passprovisional = $model->passGenerator();
					
			$model->password = $passprovisional;
			$model->activkey=UserModule::encrypting(microtime().$model->password);
			$model->password=UserModule::encrypting($model->password);
			$model->verifyPassword=UserModule::encrypting($model->verifyPassword);
			$model->superuser=0;
			$model->type = 2;
			$model->status=((Yii::app()->controller->module->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);
			$model->username = $model->email;
			
			if($model->save()){
					
				$empresa = $_POST['empresa'];
				$rol = $_POST['rol'];
				
				$hasusers = new EmpresasHasUsers;
				$hasusers->users_id = $model->id;
				$hasusers->empresas_id = $empresa;
				$hasusers->rol = $rol;
				
				$hasusers->save();
				
				$empresa_obj = Empresas::model()->findByPk($hasusers->empresas_id);
					
				$message = new YiiMailMessage;				
				$message->view = "mail_template";
				$subject = 'Te han agregado como '.$rol.' en una tienda de Telotengo.com';
						$body = "Te han agregado como ".$rol."<br/>
								<br/>
								Empresa: ".$empresa_obj->razon_social."<br/>
								
								<br/>
								Hemos creado una cuenta para ti, con tu email. Tu contraseña provisional es <b>".$passprovisional."</b><br/> 
								";
				$params              = array('subject'=>$subject, 'body'=>$body);
				$message->subject    = $subject;
				$message->setBody($params, 'text/html');                
				$message->addTo($model->email);
				$message->from = array('info@telotengo.com' => 'Telotengo');
				Yii::app()->mail->send($message);
				
				Yii::app()->user->setFlash('success',"Usuario creado correctamente.");
				$this->redirect(array('usuariostienda'));
			}

		}
		
		$this->render('user-tienda',array('model'=>$model,'profile'=>$profile,'listData'=>$list));
	}
	
	
	/**
	 * Usuarios de tienda
	 */
	public function actionUsuariostienda()
	{
		$usuario = User::model()->findByPk(Yii::app()->user->id);
		$empresashas = EmpresasHasUsers::model()->findAllByAttributes(array('users_id'=>$usuario->id,));
		
		$users = Array();
		
		foreach($empresashas as $empresas){
			
			$empresa = Empresas::model()->findByPk($empresas->empresas_id);
			
			if($empresa->tipo==2) // vendedora
			{
				$users_on = EmpresasHasUsers::model()->findAllByAttributes(array('empresas_id'=>$empresa->id));
				foreach($users_on as $usersempresa)
				{
					$temp = User::model()->findByPk($usersempresa->users_id);
					
					if (!in_array($temp, $users)){
						$users[] = $temp; // agrega usuarios de empresas en las que el usuario conectado está 
					}
				}
				
			}
		}

		$dataProvider=new CArrayDataProvider($users, array(
		    'id'=>'dataprovider-users',
		    'sort'=>array(
		        'attributes'=>array(
		             'username',
		        ),
		    ),
		    'pagination'=>array(
		        'pageSize'=>10,
		    ),
		));
	
		// $dataProvider->getData() will return a list of arrays.
		
		$this->render('admin_usuarios',array('dataProvider'=>$dataProvider,));
	}

	/**
	 * Eliminar usuario de tienda
	 */
	public function actionDeleteuser()
	{
		$usuario = User::model()->findByPk($_GET['id']);
		
		$usuariohas = EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$usuario->id));
		$usuariohas->delete(); // elimino el has empresa
		
		$usuario->delete();
		
		Yii::app()->user->setFlash('success',"Usuario eliminado correctamente.");
		
		$this->redirect(array('usuariostienda'));
	}
	
	/**
	 * Eliminar red social
	 */
	public function actionDeletesocial()
	{
		$red = Redes::model()->findByPk($_GET['id']);
		$red->delete();
		
		Yii::app()->user->setFlash('success',"Red social eliminada correctamente.");
		
		$this->redirect(array('tucuenta'));
	}
	
	/**
	 * Eliminar usuario de tienda
	 */
	public function actionEditrol()
	{
		$usuario = User::model()->findByPk($_GET['id']);
		$usuariohas = EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$usuario->id));
		
		$rol = $usuariohas->rol;

		if(isset($_POST['rol'])){
			$usuariohas->rol = $_POST['rol'];
			$usuariohas->save();
			
			Yii::app()->user->setFlash('success',"Rol editado correctamente.");
			$this->redirect(array('usuariostienda'));
		}
		
		$this->render('edit-rol',array('rol'=>$rol,'usuario'=>$usuario->email,));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User', array(
			'criteria'=>array(
		        'condition'=>'status>'.User::STATUS_BANNED,
		    ),
				
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser($id=null)
	{
		if($this->_model===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_model=User::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/*
	Función para tomar los datos personales de una solicitud
	*/
	public function actionDatos(){
		 $get="";
		 $clienteEmpresa="";	
		 if(isset($_GET['id']))
		 {
		 	$get=$_GET['id'];
		 }

	    $this->layout='//layouts/b2b';
		$model = new RegistrationForm;
        $profile = new Profile;
        $profile->regMode = true;	

        // ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
		{
			echo UActiveForm::validate(array($model,$profile));
			Yii::app()->end();
		}

		if(isset($_POST['Profile'])){
			$profile->attributes=((isset($_POST['Profile'])?$_POST['Profile']:array()));
			Yii::app()->session['atributos']=((isset($_POST['Profile'])?$_POST['Profile']:array()));
			$soucePassword = User::generarPassword();
			
			if($get==""){ // evitar el bug de dejar el registro incompleto y si es vacio es registro para empresas 
				
				/*$model->email = Yii::app()->session['usuarionuevo'];
				$model->status = 0; # se debe crear desactivo
				$model->username = Yii::app()->session['usuarionuevo']; #Mismo Mail
				$model->activkey = UserModule::encrypting(microtime().$soucePassword);
				$model->password = UserModule::encrypting($soucePassword);
				$model->verifyPassword = UserModule::encrypting($model->verifyPassword);
				$model->quien_invita = 0; #el mismo, se modifica cuando tenga ID luego del save
				$model->type = User::TYPE_USUARIO_SOLICITA;
				$profile->user_id=0;*/
				
				Yii::app()->session['vacio']=1;
				$this->redirect(array('/empresas/create'));
				
			}elseif($_GET['tipo']=="empresa"){ // invitado como empresa, falta hacer la validacion
				$model = User::model()->findByPk($get);
				$profile = $model->profile;
				$profile->attributes=((isset($_POST['Profile'])?$_POST['Profile']:array()));
				$profile->user_id =$model->id;
				
				$activation_url = Yii::app()->controller->createUrl(implode(Yii::app()->controller->module->recoveryUrl),array(
				"activkey" => $_GET['activkey'], "email" => $_GET['email'], 
				'solicitud'=>'nueva')); 
				 $clienteEmpresa=1;
				//$this->redirect(array('../'.$activation_url));
				
			}elseif($_GET['tipo']=="cliente"){ //invitado como cliente falta hacer la validacion
				/*$model = User::model()->findByPk($get);
				$profile = $model->profile;
				$profile->attributes=((isset($_POST['Profile'])?$_POST['Profile']:array()));
				$profile->user_id = $model->id;*/
				 Yii::app()->session['cliente']=$get;
				 Yii::app()->session['activation_url']=$_GET['activkey'];
				 Yii::app()->session['email']=$_GET['email'];
				  Yii::app()->session['quieninvita']=$_GET['u'];
				$activation_url = Yii::app()->controller->createUrl(implode(Yii::app()->controller->module->recoveryUrl),array(
				"activkey" => $_GET['activkey'], "email" => $_GET['email'], 
				'solicitud'=>'nueva')); 
				Yii::app()->session['url_act']=$activation_url;
				$this->redirect(array('/empresas/create'));
				/*$activation_url = Yii::app()->controller->createUrl(implode(Yii::app()->controller->module->recoveryUrl),array(
				"activkey" => $_GET['activkey'], "email" => $_GET['email'], 
				'solicitud'=>'nueva')); */
				 $clienteEmpresa=1;
			}

			if($model->validate()&&$profile->validate()){
				if($model->save()){
					if(isset(Yii::app()->session['usuarionuevo'])){
						$model->quien_invita = $model->id;
						$model->save();
					}

					$profile->user_id = $model->id;
					/*if(isset($profile->fecha_nacimiento))
						$profile->fecha_nacimiento = date("d-m-Y", strtotime($profile->fecha_nacimiento));*/
					$profile->save();
					
					#enviar correo de que se ha inscrito (?) incluyendo su password generado

					#Log in
					/*$identity = new UserIdentity($model->username,$soucePassword);
					$identity->authenticate();
					Yii::app()->user->login($identity,0);*/

					/*
					Ya existe la empresa. Por lo que no se solicitan mas datos.
					*/ 
					
					if($clienteEmpresa!='')
					{
						$this->redirect($activation_url);
					}
					if($get!=""){ 
						$this->redirect(array('/empresas/solicitudFinalizada'));				
					}else{
						#pedir nuevos datos
						$this->redirect(array('/empresas/create'));
					}					
					
				}
			}
		}

	$this->render('datos',array('model'=>$model,'profile'=>$profile, 'get'=>$get));
	}

	public function actionSetPassword()
	{
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
								if ($find->status==0) {
									$find->status = 1;
								}
								$find->save();
								Yii::app()->user->setFlash('recoveryMessage',UserModule::t("New password is saved."));
								$this->redirect(Yii::app()->controller->module->recoveryUrl);
							}
						} 
						$this->render('changepassword',array('form'=>$form2));
		    		} else {
		    			Yii::app()->user->setFlash('recoveryMessage',UserModule::t("Incorrect recovery link."));
						$this->redirect(Yii::app()->controller->module->recoveryUrl);
		    		}
		    	} else {
			    	if(isset($_POST['UserRecoveryForm'])) {
			    		$form->attributes=$_POST['UserRecoveryForm'];
			    		if($form->validate()) {
			    			$user = User::model()->notsafe()->findbyPk($form->user_id);
							$activation_url = 'http://' . $_SERVER['HTTP_HOST'].$this->createUrl(implode(Yii::app()->controller->module->recoveryUrl),array("activkey" => $user->activkey, "email" => $user->email));
							
							// Enviar correo con link de recuperación de contraseña
                                                    $message            = new YiiMailMessage;
                                                    //Opciones de Mandrill
                                                    $message->activarPlantillaMandrill();
                                                    $subject = 'Recupera tu contraseña de Personaling';
                                                    $body = Yii::t('contentForm','<h2>You have requested to change your password</h2> To receive a new password, click on the following link: <br/><br/> <a href="{url}">Click Here</a><br/><br/> If you have not been you who requested the change, please contact us via info@personaling.com',array('{url}'=>$activation_url));		
						    $message->subject    = $subject;
						    $message->setBody($body, 'text/html');                
						    $message->addTo($user->email);
						    Yii::app()->mail->send($message);
//                                                    $message->from = array('info@personaling.com' => 'Tu Personal Shopper Online');
//						    $message->view = "mail_template";
//						    $params              = array('subject'=>$subject, 'body'=>$body);
							
							Yii::app()->user->setFlash('recoveryMessage',UserModule::t("Please check your email. An instructions was sent to your email address."));
			    			$this->refresh();
			    		}
			    	}
		    		$this->render('recovery',array('form'=>$form));
		    	}
		
	}

    public function actionActivarDesactivar()
    {
        $id=$_POST['id'];
        $model = User::model()->findByPk($id);
        $model->status=1-$model->status;
		if($model->registro_password==0)
		{
			echo $rol=$model->buscarRol($id);
			$model->registro_password=1;
			$model->newPassword($id, $rol);
		}

        $model->save();
        echo $model->status;
		
        
    }
	
	public function actionBorrar()
	{
		$this->render('borrar');
	}

}
