<?php

class FlashsaleController extends Controller 
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
		//	'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('admin','delete','seleccion','busqueda'), 
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
		$model=new Flashsale;
		
		if(isset($_GET['id'])){
			$model = Flashsale::model()->findByPk($_GET['id']);
		}
			
		if(isset($_GET['inventario_id'])){
			$inventario_id = $_GET['inventario_id']; 
			$inventario = Inventario::model()->findByPk($inventario_id);
			
			$producto = Producto::model()->findByPk($inventario->producto_id);
			
			$caracteristicas = Caracteristica::model()->findAllByAttributes(array('inventario_id'=>$inventario_id));	
			$codigo=""; 
				
			foreach($caracteristicas as $caracteristica){
				$carac_sql = CaracteristicasSql::model()->findByPk($caracteristica->caracteristica_id);
					
				$nombre = $carac_sql->nombre;
				$valor = $caracteristica->valor;
					
				$codigo = $codigo."<b>".$nombre."</b>: ".$valor.". ";
			}
				$codigo=$codigo."<b>Cantidad en existencia: </b>".$inventario->cantidad;
			
			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);
		}
	
		if(isset($_POST['Flashsale'])) 
		{
			$model->attributes=$_POST['Flashsale'];
			
			$flashsales = Flashsale::model()->findAllByAttributes(array('inventario_id'=>$model->inventario_id,'estado'=>1)); // del inventario y activa
			
			if(!count($flashsales)>0){
				if($model->save()){
					Yii::app()->user->setFlash('success',"Flashsale creado correctamente.");
					$this->redirect(array('admin'));
				}
			}
			else {
				Yii::app()->user->setFlash('error',"No puede crear una venta flash a un producto que ya tiene una venta activa.");
				$this->redirect(array('admin'));
			}
		} 

		$this->render('create',array(
			'model'=>$model,
			'producto'=>$producto,
			'inventario'=>$inventario,
			'codigo'=>$codigo, 
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

		if(isset($_POST['Flashsale']))
		{
			$model->attributes=$_POST['Flashsale'];
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
		$flashsale = Flashsale::model()->findByPk($id);
		$flashsale->delete();
		
		Yii::app()->user->setFlash('success',"Venta Flash eliminada correctamente.");
		
		$this->redirect(array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Flashsale');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	// seleccion entre crear o buscar
	public function actionSeleccion() 
	{
		if(isset($_POST['busqueda'])){
			unset(Yii::app()->session['busqueda']);
				
			Yii::app()->session['busqueda'] = $_POST['busqueda'];
			
			$this->redirect(array('busqueda'));
		}
		else
			$this->render('seleccion');
	}

	// el usuario decidio buscar el producto
	public function actionBusqueda()
	{		
		$producto = new Producto;
		$producto->unsetAttributes();  
		
		if(Yii::app()->session['busqueda']){
			$producto->nombre = Yii::app()->session['busqueda'];
		}
		$dataProvider = $producto->searchTwo(); 
			
		$this->render('busqueda',array('dataProvider'=>$dataProvider));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Flashsale('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Flashsale']))
			$model->attributes=$_GET['Flashsale'];
		
		$dataProvider = $model->search();
		
		$this->render('admin',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Flashsale the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Flashsale::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Flashsale $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='flashsale-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
