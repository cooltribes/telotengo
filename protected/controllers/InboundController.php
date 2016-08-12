<?php

class InboundController extends Controller 
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
				'actions'=>array('create','update', 'administrador', 'descargarExcel'),
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Inbound;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Inbound']))
		{
			$model->attributes=$_POST['Inbound'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['Inbound']))
		{
			$model->attributes=$_POST['Inbound'];
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
		/*$dataProvider=new CActiveDataProvider('Inbound');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));*/
		$this->redirect('admin');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdministrador()  /// para cada usuario, falta el general
	{
		$inbound = new Inbound; 
		$inbound->unsetAttributes();
		$bandera=false;
		$dataProvider = $inbound->searchPropio();

		/* Para mantener la paginacion en las busquedas */
		if(isset($_GET['ajax']) && isset($_SESSION['searchInbound']) && !isset($_POST['query'])){
			$_POST['query'] = $_SESSION['searchInbound'];
			$bandera=true;
		}

		/* Para buscar desde el campo de texto */
		if (isset($_POST['query'])){
			$bandera=true;
			unset($_SESSION['searchInbound']);
			$_SESSION['searchInbound'] = $_POST['query'];
            $dataProvider = $inbound->searchPropio($_POST['query']);
        }	

        if($bandera==FALSE){
			unset($_SESSION['searchInbound']);
        }
		
		$this->render('administrador',
			array('model'=>$inbound,
			'dataProvider'=>$dataProvider,
		));
	}
	
	
	public function actionAdmin()  /// para cada usuario, falta el general
	{
		$inbound = new Inbound; 
		$inbound->unsetAttributes();
		$bandera=false;
		$dataProvider = $inbound->search();

		/* Para mantener la paginacion en las busquedas */
		if(isset($_GET['ajax']) && isset($_SESSION['searchInbound']) && !isset($_POST['query'])){
			$_POST['query'] = $_SESSION['searchInbound'];
			$bandera=true;
		}

		/* Para buscar desde el campo de texto */
		if (isset($_POST['query'])){
			$bandera=true;
			unset($_SESSION['searchInbound']);
			$_SESSION['searchInbound'] = $_POST['query'];
			//$inbound->id=$_POST['query'];
            $dataProvider = $inbound->search($_POST['query']);
        }	

        if($bandera==FALSE){
			unset($_SESSION['searchInbound']);
        }
		
		$this->render('admin',
			array('model'=>$inbound,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Inbound the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Inbound::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Inbound $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='inbound-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionDescargarExcel()
	{
            //Revisar la extension
            $archivo = Yii::getPathOfAlias("webroot").'/docs/xlsMasterData/inbound/'.
                    $_GET["id"].".xlsx";
            $existe = file_exists($archivo);
            
            //si no existe con extension xlsx, poner xls
            if(!$existe){
                $archivo = substr($archivo, 0, -1);
            }
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=Inbound-'.basename($archivo));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($archivo));
            ob_clean();
            flush();
            readfile($archivo);
            
	}
}
