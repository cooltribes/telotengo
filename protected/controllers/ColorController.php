<?php

class ColorController extends Controller
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'busqueda', 'index'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'borrar'),
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
		$model=new Color;
		#$model->scenario="create"; 
		// Uncomment the following line if AJAX validation is needed
		 //$this->performAjaxValidation($model);

		if(isset($_POST['Color']))
		{
			$model->attributes=$_POST['Color'];
			#$model->nombre=ucwords($_POST['Color']['nombre']); //convierte cada primera letra en mayusculas
			if(!$model->save())
			{
				print_r($model->getError());
			}
			else {
				Yii::app()->user->setFlash('success',"Color creado correctamente.");
				$this->redirect(array('admin'));
				
			}
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
	   #  $this->performAjaxValidation($model);

		if(isset($_POST['Color']))
		{
			$model->attributes=$_POST['Color'];
			$model->nombre=ucwords($_POST['Color']['nombre']); //convierte cada primera letra en mayusculas	
			if($model->save())
			{
				$this->redirect(array('admin'));
			}
			else {
				print_r($model->getError());
			}
				
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
		/*$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		Yii::app()->user->setFlash('success',"Color eliminada correctamente.");
		
		$this->redirect(array('admin'));*/
		echo "asdfsjkdfghkjsdfg";
		Yii::app()->end();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Color');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$color = new Color; 
		$color->unsetAttributes();
		$bandera=false;
		$dataProvider = $color->search();

		/* Para mantener la paginacion en las busquedas */
		if(isset($_GET['ajax']) && isset($_SESSION['searchColor']) && !isset($_POST['query'])){
			$_POST['query'] = $_SESSION['searchColor'];
			$bandera=true;
		}

		/* Para buscar desde el campo de texto */
		if (isset($_POST['query'])){
			$bandera=true;
			unset($_SESSION['searchColor']);
			$_SESSION['searchColor'] = $_POST['query'];
            $color->nombre = $_POST['query'];
            $dataProvider = $color->search();
        }	

        if($bandera==FALSE){
			unset($_SESSION['searchColor']);
        }

		
		$this->render('admin',
			array('model'=>$color,
			'dataProvider'=>$dataProvider,
		));	
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Color the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Color::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Color $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='color-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	public function actionBusqueda()
	{
		$nombre=$_POST['nombre'];
		$idAct=$_POST['idAct'];
		$busqueda=Color::model()->findByAttributes(array('nombre'=>$nombre));
		if($busqueda=="")
		{
			echo "1";
			if($idAct=="")
				$guardar=1;
			else
				$guardar=2;
		}
		else 
		{
			if($busqueda->id==$idAct)
			{
				echo "1";
				$guardar=2;
			}	
			else
			{
				echo "0";
				$guardar=0;	
			}
						
		}
		if($guardar==1)
		{
			$color = new Color; 
			$color->nombre=$nombre;
			$color->save();
			$color->refresh();
			Yii::app()->user->setFlash('success',"Color creado correctamente.");
			$log=new Log;
			$log->id_color=$color->id;
			$log->fecha=date('Y-m-d G:i:s');
			$log->id_admin=Yii::app()->user->id;
			$log->accion=32; //has creado un color
		}
		if($guardar==2)
		{
			$model=Color::model()->findByPk($idAct);
			$model->nombre=$nombre;
			$model->save();
			$model->refresh();
			Yii::app()->user->setFlash('success',"Color modificado correctamente.");
			$log=new Log;
			$log->id_color=$model->id;
			$log->fecha=date('Y-m-d G:i:s');
			$log->id_admin=Yii::app()->user->id;
			$log->accion=33; //has modificado un color
		}
		$log->save();
		
		
	
	}
	
	public function actionBorrar($id)
	{
	
		$model=$this->loadModel($id);
		$model->activo=1-$model->activo;
		$model->save();
		$model->refresh();
	    $log=new Log;
		$log->id_color=$model->id;
		$log->fecha=date('Y-m-d G:i:s');
		$log->id_admin=Yii::app()->user->id;
		if($model->activo==0)
		{
			$log->accion=34; //desactivo el color
			$mensaje="Color desactivado correctamente."; 
		}
        else
        {
            $log->accion=35; //activo el color
            $mensaje="Color activado correctamente."; 
        }
        $log->save();
		
		Yii::app()->user->setFlash('success',$mensaje);
		
		$this->redirect(array('admin'));
	}
}
