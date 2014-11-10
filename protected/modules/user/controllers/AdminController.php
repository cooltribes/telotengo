<?php

class AdminController extends Controller
{
	public $defaultAction = 'admin';
	public $layout='//layouts/column2';
	
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','view','cargarSaldo','reclamos','eliminarReclamo','eliminarComentario'),
				'users'=>UserModule::getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['User']))
            $model->attributes=$_GET['User'];

        $this->render('index',array(
            'model'=>$model,
        ));
		/*$dataProvider=new CActiveDataProvider('User', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));//*/
	}

	/**
	 * Cargar saldo a un usario
	 */
	public function actionCargarSaldo($id)
	{
		$balance = new Balance();
		$usuario = User::model()->findByPk($id);

		if(isset($_POST['Balance'])){
			$balance->attributes=$_POST['Balance'];
			$balance->orden_id = 0; // carga de saldo desde admin, no tiene orden_id
			$balance->user_id = $id;
			$balance->tipo = 3; // carga desde el admin
			if($balance->save()){
				Yii::app()->user->setFlash('success',"Saldo cargado");
				$this->redirect(array('admin'));
			}
		}

		$this->render('cargar_saldo',array(
			'balance'=>$balance,
		));
	}

	/**
	 * Admin de reclamos
	 */
	public function actionReclamos()
	{
		$model=new Reclamo;
		$model->unsetAttributes();  // clear any default values
		
		$dataProvider = $model->search();

		$this->render('reclamos',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Eliminar reclamo
	 */
	public function actionEliminarReclamo($id)
	{
		$model = Reclamo::model()->findByPk($id);
		$model->delete();
		Yii::app()->user->setFlash('success',"Reclamo eliminado");
		$this->redirect(array('reclamos'));
	}

	/**
	 * Eliminar comentario para un reclamo
	 */
	public function actionEliminarComentario($id)
	{
		$model = ReclamoComentarios::model()->findByPk($id);
		$model->delete();
		Yii::app()->user->setFlash('success',"Comentario eliminado");
		$this->redirect(array('reclamos'));
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id = null)
	{
		$model=new User;
		$profile=new Profile;
		if($id){
			$model = User::model()->findByPk($id);
			$profile = $model->profile;
		}
		
		
		$this->performAjaxValidation(array($model,$profile));
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
			$profile->attributes=$_POST['Profile'];
			$profile->user_id=0;
			if($model->validate()&&$profile->validate()) {
				$model->password=Yii::app()->controller->module->encrypting($model->password);
				if($model->save()) {
					$profile->user_id=$model->id;
					$profile->save();
					Yii::app()->user->setFlash('success',"Usuario guardado");
				}
				$this->redirect(array('admin'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();
		$profile=$model->profile;
		$this->performAjaxValidation(array($model,$profile));
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			
			if($model->validate()&&$profile->validate()) {
				$old_password = User::model()->notsafe()->findByPk($model->id);
				if ($old_password->password!=$model->password) {
					$model->password=Yii::app()->controller->module->encrypting($model->password);
					$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
				}
				$model->save();
				$profile->save();
				$this->redirect(array('view','id'=>$model->id));
			} else $profile->validate();
		}

		$this->render('update',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete($id)
	{
		//if(Yii::app()->request->isPostRequest)
		//{
			// we only allow deletion via POST request
		$model = User::model()->findByPk($id);
		$profile = Profile::model()->findByPk($model->id);
		$profile->delete();
		$model->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		//if(!isset($_POST['ajax']))
		Yii::app()->user->setFlash('success',"Usuario eliminado");
		$this->redirect(array('/user/admin'));
		//}
		//else
		//	throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($validate)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
        {
            echo CActiveForm::validate($validate);
            Yii::app()->end();
        }
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
				$this->_model=User::model()->notsafe()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
	
}