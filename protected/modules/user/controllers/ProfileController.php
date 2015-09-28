<?php

class ProfileController extends Controller
{
	public $defaultAction = 'profile';
	public $layout='//layouts/column2';

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
				'actions'=>array('index','view','profile','welcome'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('edit','changepassword'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}	


	/**
	 * Shows a particular model.
	 */
	public function actionProfile($id = null)
	{
		if($id){
			$model = User::model()->findByPk($id);
		}else{
			$model = User::model()->findByPk(Yii::app()->user->id);
		}
		if(isset($_POST['imagen']))
		{
			if(!is_dir(Yii::getPathOfAlias('webroot').'/images/user/'))
			{
	   			mkdir(Yii::getPathOfAlias('webroot').'/images/user/',0777,true);
	 		}	
			$rnd = rand(0,9999);  	
			$images=CUploadedFile::getInstanceByName('imagen');
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
			/*	echo "s;kdfklsdf";
				Yii::app()->end();*/
			}
		}
		
	    $this->render('profile',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}

	/**
	 * Welcome screen after user registration
	 */
	public function actionWelcome()
	{
		$model = $this->loadUser();
	    $this->render('welcome',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEdit()
	{
		$model = $this->loadUser();
		$profile=$model->profile;
		
		// ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
		{
			echo UActiveForm::validate(array($model,$profile));
			Yii::app()->end();
		}
		
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			
			if($model->validate()&&$profile->validate()) {
				$model->save();
				$profile->save();
				Yii::app()->user->setFlash("success", "Cambios actualizados.");

				if($profile->telefono!="" && $profile->sexo){
					$porcentaje = $profile->isAllPercentage();

	                if($porcentaje && ($model->perfil_completo==0)){
	                	$model->perfil_completo = 1;
	                	if($model->save()){
	                		# Sumar 500 bs al balance
	                		$balance = new Balance;
	                		$balance->total = 500;
	                		$balance->orden_id = 0;
	                		$balance->user_id = $model->id;
	                		$balance->tipo = 5;
	                		$balance->save();
	                		Yii::app()->user->setFlash('success', 'Cambios actualizados. Además hemos sumado 500 Bs a tu saldo.');
	               			$model->mailCompletarPerfil(); // correo por completar perfil
	               		}// save
	                }// porcentaje
				} // telefono y genero

                Yii::app()->user->updateSession();
				$this->redirect(array('/user/user/tucuenta'));
			} else $profile->validate();
		}

		$this->render('edit',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}
	
	/**
	 * Change password
	 */
	public function actionChangepassword(){
		$model = new UserChangePassword;
		if (Yii::app()->user->id) {
			
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changepassword-form')
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}
			
			if(isset($_POST['UserChangePassword'])) {
					$model->attributes=$_POST['UserChangePassword'];
					if($model->validate()) {
						$new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
						$new_password->password = UserModule::encrypting($model->password);
						$new_password->activkey=UserModule::encrypting(microtime().$model->password);
						if ($new_password->save()) {
							Yii::app()->user->setFlash('success', 'Se ha cambiado correctamente la contraseña.');
							$this->redirect(array("user/tucuenta"));
						}else{
							print_r($new_password->getErrors());
							die();
						}
					}
			}
			$this->render('changepassword',array('model'=>$model));
	    }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser()
	{
		if($this->_model===null)
		{
			if(Yii::app()->user->id)
				$this->_model=Yii::app()->controller->module->user();
			if($this->_model===null)
				$this->redirect(Yii::app()->controller->module->loginUrl);
		}
		return $this->_model;
	}
}