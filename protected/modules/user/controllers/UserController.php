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
				'actions'=>array('index','view','favoritos'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('tucuenta','usuariostienda','createuser','deleteuser','editrol','avatar','agregarsocial','deletesocial','privacidad','notificaciones'),
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
	
	/**
	 * Tu cuenta
	 */
	public function actionTucuenta()
	{
		$model = User::model()->findByPk(Yii::app()->user->id);
		
		$empresas = new EmpresasHasUsers;
		$empresas->users_id = $model->id;
		
		$redes = new Redes;
		$redes->users_id = $model->id;
		
		$provider = $redes->search();
		
		$dataProvider = $empresas->search();
		
		$this->render('tu_cuenta',array('model'=>$model,'dataProvider'=>$dataProvider,'provider'=>$provider,));
	}

	public function actionFavoritos(){
		$model = new UserFavoritos;
		$model->user_id = Yii::app()->user->id;

		$dataProvider = $model->search();

		$this->render('favoritos',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionAgregarSocial(){
			
		$model = new Redes();
		
		if(isset($_POST['Redes'])){
			
			$user = User::model()->findByPk(Yii::app()->user->id);	
			$model->users_id = $user->id;
			
            $model->attributes=$_POST['Redes'];
            if($model->save()){
                Yii::app()->user->setFlash('success', 'Datos guardados con éxito');
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
}
