<?php

class AtributoController extends Controller 
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
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'activarDesactivar'),
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
		$model=new Atributo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Atributo']))
		{
			$model->attributes=$_POST['Atributo'];
			if($_POST['Atributo']['tipo']!=3)
			{
					$model->multiple=0;
					$model->rango="";
			}
			$model->descripcion=$_POST['Atributo']['descripcion'];

			$model->nombre_mongo=Funciones::cleanUrlSeo($model->nombre);

			if($model->save())
			{
				$log=new Log;
				$log->id_atributo=$model->id;
				$log->fecha=date('Y-m-d G:i:s');
				$log->id_admin=Yii::app()->user->id;
				$log->accion=40;
				$log->save();
				$this->redirect(array('admin'));
			}
		}
		else {
	
		
			if(isset($_POST['nombre'])) // si viene algo por json
			{
			
				$vector=$_POST['vector'];
				if($_POST['idAct']=="")
				{
					$model=new Atributo;
					$nuevo=1;	
				}
				else 
				{
					$model=Atributo::model()->findByPk($_POST['idAct']);
					$nuevo=0;
				}
					
				$model->nombre=$_POST['nombre'];
				$model->obligatorio=$_POST['obligatorio'];
				$model->tipo=$_POST['tipo'];
				$model->descripcion=$_POST['descripcion'];
				
				if($_POST['tipo']==3)
				{
					$model->tipo_unidad="";	
					$model->multiple=$_POST['multiple'];
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
								$cadena=$suma."==".$vec;
							else 
								$cadena=$cadena.",".$suma."==".$vec;	
							$i++;	
							$suma=$suma*$multiplicacion;
						}			
					}
					$model->rango=$cadena;
				}
				else
				{
					$model->multiple=0;
					$model->rango="";
				}
			  	$model->save();
			    $model->refresh();
			    $log=new Log;
			    $log->id_atributo=$model->id;
			    $log->fecha=date('Y-m-d G:i:s');
			    $log->id_admin=Yii::app()->user->id;
			    if($nuevo==1)
			   		$log->accion=40;// creo la unidad
			   	else
			   		$log->accion=41; // modifico la unidad
			    $log->save();

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
		// $this->performAjaxValidation($model);

		if(isset($_POST['Atributo']))
		{
			$model->attributes=$_POST['Atributo'];
			if($_POST['Atributo']['tipo']!=3)
			{
					$model->multiple=0;
					$model->rango=""; 
			}
			else 
			{
				$model->tipo_unidad="";	
			}
			$model->descripcion=$_POST['Atributo']['descripcion'];
			if($model->save())
			{
				$log=new Log;
			    $log->id_atributo=$model->id;
			    $log->fecha=date('Y-m-d G:i:s');
			    $log->id_admin=Yii::app()->user->id;
			   	$log->accion=41; // modifico la unidad
			    $log->save();
				$this->redirect(array('admin'));
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
	public function actionActivarDesactivar($id)
	{
		/*$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));*/
		//$id=$_POST['id'];
		$model = Atributo::model()->findByPk($id);
		$model->activo=1-$model->activo;
		$model->save();
		$model->refresh();
		$log=new Log;
		$log->id_atributo=$model->id;
		$log->fecha=date('Y-m-d G:i:s');
		$log->id_admin=Yii::app()->user->id;
		if($model->activo==0)
		{
			$log->accion=42; //desactivo el atributo
			$mensaje="Atributo desactivado correctamente."; 
		}
        else
        {
            $log->accion=43; //activo el atributo
            $mensaje="Atributo activado correctamente."; 
        }
		$log->save();
		Yii::app()->user->setFlash('success',$mensaje);
		
		$this->redirect(array('admin'));
				echo $model->activo;
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Atributo');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$atributo = new Atributo; 
		$atributo->unsetAttributes();
		$bandera=false;
		$dataProvider = $atributo->search();

		/* Para mantener la paginacion en las busquedas */
		if(isset($_GET['ajax']) && isset($_SESSION['searchAtributo']) && !isset($_POST['query'])){
			$_POST['query'] = $_SESSION['searchAtributo'];
			$bandera=true;
		} 

		/* Para buscar desde el campo de texto */
		if (isset($_POST['query'])){
			$bandera=true;
			unset($_SESSION['searchAtributo']);
			$_SESSION['searchAtributo'] = $_POST['query'];
            $atributo->nombre = $_POST['query'];
            $dataProvider = $atributo->search();
        }	

        if($bandera==FALSE){
			unset($_SESSION['searchAtributo']);
        }

		
		$this->render('admin',
			array('model'=>$atributo,
			'dataProvider'=>$dataProvider,
		));	
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Atributo the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Atributo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Atributo $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='atributo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
