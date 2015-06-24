<?php

class UnidadController extends Controller
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
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'creacion', 'actualizar', 'actualizacion'),
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
		$model=new Unidad;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Unidad']))
		{
			$model->attributes=$_POST['Unidad'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionCreacion()
	{
			$vector=$_POST['vector'];
			$model=new Unidad;	
			$model->nombre=$_POST['nombre'];
			$suma=1;
			$multiplicacion=2;
			$cadena="";
			$i=0;
			$rango="";
			foreach($vector as $vec)
			{
				if($i==0)
				{
					$cadena=$suma."==".$vec;
				}
				else 
				{
					$cadena=$cadena.",".$suma."==".$vec;
				}	
				$i++;	
				$suma=$suma*$multiplicacion;
				
			}
			$model->rango=$cadena;
			$model->save();
		
	}
	public function actionActualizacion()
	{
			$vector=$_POST['vector'];
			$model=Unidad::model()->findByPk($_POST['idAct']);
			$model->nombre=$_POST['nombre'];
			$suma=1;
			$multiplicacion=2;
			$cadena="";
			$i=0;
			$rango="";
			foreach($vector as $vec)
			{
				if($vec!="noIndexado")
				{
					if($i==0)
					{
						$cadena=$suma."==".$vec;
					}
					else 
					{
						$cadena=$cadena.",".$suma."==".$vec;
					}	
					$i++;	
					$suma=$suma*$multiplicacion;
				}	
	
			}
			$model->rango=$cadena;
			$model->save();
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

		if(isset($_POST['Unidad']))
		{
			$model->attributes=$_POST['Unidad'];
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

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Unidad');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		/*$model=new Unidad('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Unidad']))
			$model->attributes=$_GET['Unidad'];

		$this->render('admin',array(
			'model'=>$model,
		));*/
		
		$unidad = new Unidad; 
		$unidad->unsetAttributes();
		$bandera=false;
		$dataProvider = $unidad->search();

		/* Para mantener la paginacion en las busquedas */
		if(isset($_GET['ajax']) && isset($_SESSION['searchUnidad']) && !isset($_POST['query'])){
			$_POST['query'] = $_SESSION['searchUnidad'];
			$bandera=true;
		}

		/* Para buscar desde el campo de texto */
		if (isset($_POST['query'])){
			$bandera=true;
			unset($_SESSION['searchUnidad']);
			$_SESSION['searchUnidad'] = $_POST['query'];
            $unidad->nombre = $_POST['query'];
            $dataProvider = $unidad->search();
        }	

        if($bandera==FALSE){
			unset($_SESSION['searchUnidad']);
        }
/*
		if (isset($_POST['query'])){
			$unidad->nombre = $_POST['query'];
		}*/
		
		$this->render('admin',
			array('model'=>$unidad,
			'dataProvider'=>$dataProvider,
		));	
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Unidad the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Unidad::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Unidad $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='unidad-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
