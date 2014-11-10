<?php

class ControlPanelController extends Controller
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
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(''),
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
	
	public function actionAdmin()
	{
		$empresas = Empresas::model()->findAll(array('order' => 'id'));
		$mensaje = new Mensajes;
		$nuevomensaje = new Mensajes;
		
		if(isset($_POST['Mensajes'])){
			$nuevomensaje->attributes = $_POST['Mensajes'];
			$nuevomensaje->from_id = Yii::app()->user->id;
			$nuevomensaje->to_id = $_POST['empresa'];
			$nuevomensaje->fecha = date('Y-m-d H:i:s');
			$nuevomensaje->estado = 0; // sin leer
			
			if($nuevomensaje->save())
				Yii::app()->user->setFlash('success',"Email enviado exitosamente.");
			else
				Yii::app()->user->setFlash('error',"No enviado.");
				
		}
			
		$this->render('admin',array('empresas'=>$empresas,'mensaje'=>$mensaje));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}