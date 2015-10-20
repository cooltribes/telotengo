<?php

class AlmacenController extends Controller
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
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('create','update','listado','delete'), 
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
	public function actionCreate($id_empresa)
	{
		$model = new Almacen;
		$empresa = Empresas::model()->findByPk($id_empresa);
		$model->empresas_id = $empresa->id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Almacen']))
		{
			$model->attributes=$_POST['Almacen'];
			 $model->nombre=$_POST['Almacen']['nombre'];
			if($model->save()){
				Yii::app()->user->setFlash('success',"Almacen agregado con éxito");
			}else{
				Yii::app()->end();
				Yii::app()->user->setFlash('error',"Error al guardar el Almacen");
			}
			$this->redirect(array('listado','id_empresa'=>$empresa->id));
		}

		$this->render('create',array(
			'model'=>$model,
			'empresa'=>$empresa,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionListado($id_empresa)
	{
		$model=new Almacen;
		$model->unsetAttributes();  // clear any default values
		$model->empresas_id = $id_empresa;
		$empresa = Empresas::model()->findByPk($id_empresa);
		$this->render('listado',array(
			'model'=>$model,
			'empresa'=>$empresa,
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

		if(isset($_POST['Almacen']))
		{
			$model->attributes=$_POST['Almacen'];
			$model->nombre=$_POST['Almacen']['nombre'];
			if($model->save()){
				Yii::app()->user->setFlash('success',"Almacen modificado con éxito");
			}else{
				Yii::app()->user->setFlash('error',"Error al modificar el Almacen");
			}
			if(!Yii::app()->authManager->checkAccess("admin", Yii::app()->user->id))
				$this->redirect(array('listado','id_empresa'=>$model->empresas_id));
			else
				$this->redirect(array('admin'));
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
		$almacen = Almacen::model()->findByPk($_POST['id']);
		$almacen->delete();
		//$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		/*if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));*/
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Almacen');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$almacen = new Almacen; 
		$almacen->unsetAttributes();
		$bandera=false;
		$dataProvider = $almacen->search();

		/* Para mantener la paginacion en las busquedas */
		if(isset($_GET['ajax']) && isset($_SESSION['searchAlmacen']) && !isset($_POST['query'])){
			$_POST['query'] = $_SESSION['searchAlmacen'];
			$bandera=true;
		}

		/* Para buscar desde el campo de texto */
		if (isset($_POST['query'])){
			$bandera=true;
			unset($_SESSION['searchAlmacen']);
			$_SESSION['searchAlmacen'] = $_POST['query'];
            $almacen->nombre = $_POST['query'];
            $dataProvider = $almacen->search();
        }	

        if($bandera==FALSE){
			unset($_SESSION['searchAlmacen']);
        }
/*
		if (isset($_POST['query'])){
			$almacen->nombre = $_POST['query'];
		}*/
		
		$this->render('admin',
			array('model'=>$almacen,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Almacen the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Almacen::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Almacen $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='almacen-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
