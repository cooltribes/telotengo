<?php

class DatosPagoController extends Controller
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
				'actions'=>array('create','listado','delete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if($_GET['id']){
			$model = DatosPago::model()->findByPk($_GET['id']);	
		}
		else{
			$model=new DatosPago;	
		}	
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DatosPago']))
		{
			$model->attributes = $_POST['DatosPago'];
			$model->users_id = Yii::app()->user->id;
			$model->rif = $_POST['DatosPago']['rif'];
			$model->banco = $_POST['DatosPago']['banco'];
			
			if($model->save()){
				Yii::app()->user->setFlash('success',"Datos guardados exitosamente.");
				$this->redirect(array('listado'));			
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function actionListado(){
		$model = new DatosPago;
		
		$model->users_id = Yii::app()->user->id;
		$dataProvider = $model->search();
		
		$this->render('listado',array(
			'model' => $model,
			'dataProvider' => $dataProvider,
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

		if(isset($_POST['DatosPago']))
		{
			$model->attributes=$_POST['DatosPago'];
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
	public function actionDelete()
	{
		$id = $_GET['id'];
		$this->loadModel($id)->delete();

		Yii::app()->user->setFlash('success',"Dato eliminado exitosamente.");
		$this->redirect(array('listado'));		
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('DatosPago');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new DatosPago('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DatosPago']))
			$model->attributes=$_GET['DatosPago'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return DatosPago the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=DatosPago::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param DatosPago $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='datos-pago-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
