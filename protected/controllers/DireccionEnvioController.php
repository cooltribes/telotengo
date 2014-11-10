<?php

class DireccionEnvioController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','listado','cargarciudades','delete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	/**
	 * Listado de direcciones para usuario comun
	 */
	public function actionListado()
	{
		$model = new DireccionEnvio;
		$model->unsetAttributes();
		
		if(isset($_POST['query'])){
			$model->nombre = $_POST['query'];
		}
		
		$model->users_id = Yii::app()->user->id; // solo los del usuario
		$dataProvider = $model->search();
		
		$this->render('listado',
			array('model'=>$model,
			'dataProvider'=>$dataProvider,
		));	
	
	}
	
	/*
	 * Carga las ciudad correspondientes a una provincia
	 * */
	public function actionCargarCiudades(){
		
		if(isset($_POST['provincia_id'])){
			$ciudades = Ciudad::model()->findAllByAttributes(array('provincia_id'=>$_POST['provincia_id']), array('order'=>'nombre ASC'));
			
			if(sizeof($ciudades) > 0){
				$return = '';
				
				foreach ($ciudades as $ciudad) {
					$return .= '<option value="'.$ciudad->id.'">'.$ciudad->nombre.'</option>';
				}
				
				echo $return;
			}
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id = null)
	{
		if(!$id){
			$model=new DireccionEnvio;
		}else{
			$model = DireccionEnvio::model()->findByPk($id);
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DireccionEnvio']))
		{
			$model->attributes=$_POST['DireccionEnvio'];
			$model->users_id = Yii::app()->user->id;

			$user = User::model()->findByPk(Yii::app()->user->id); 
			
			if($model->save())
				if($user->superuser == 1)
					$this->redirect(array('admin'));
				else
					$this->redirect(array('listado'));
			
		}
				
		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DireccionEnvio']))
		{
			$model->attributes=$_POST['DireccionEnvio'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{	
		$this->loadModel($id)->delete();
		
		Yii::app()->user->setFlash('success',"Dirección eliminada correctamente.");
		
		$this->redirect(array('listado'));		
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('DireccionEnvio');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new DireccionEnvio;
		$model->unsetAttributes();
		
		$dataProvider = $model->search();
		
		$this->render('admin',
			array('model'=>$model,
			'dataProvider'=>$dataProvider,
		));	
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=DireccionEnvio::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='direccion-envio-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
