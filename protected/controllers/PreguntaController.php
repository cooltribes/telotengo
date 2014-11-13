<?php

class PreguntaController extends Controller
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
				'actions'=>array('create','update','preguntas'),
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
		$model=new Pregunta;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pregunta']))
		{
			$model->attributes=$_POST['Pregunta'];
			$model->fecha = date('Y-m-d H:i:s');
			$model->producto_id = $_POST['id'];
			$model->users_id = Yii::app()->user->id;
			
			if($model->save())
			{
				Yii::app()->user->setFlash('success',"Lista de deseos creada correctamente.");
				$this->redirect(array('producto/detalle','id'=>$model->producto_id));
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

		if(isset($_POST['Pregunta']))
		{
			$model->attributes=$_POST['Pregunta'];
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
		$respuestas = Respuesta::model()->findAllByAttributes(array('pregunta_id'=>$id));
		
		foreach($respuestas as $respuesta){
			$respuesta->delete();
		}
			
		$this->loadModel($id)->delete();
		Yii::app()->user->setFlash('success',"Pregunta eliminada correctamente.");
		$this->redirect(array('admin'));
	}
	
	public function actionPreguntas()
	{
		$productos = array();
		
		/*$sql='select DISTINCT a.* from tbl_pregunta a, tbl_inventario c, tbl_empresas_has_tbl_users d, tbl_empresas e, tbl_users f where f.id='.Yii::app()->user->id.'
			and e.tipo=2 and d.users_id ='.Yii::app()->user->id.' and c.producto_id = a.producto_id and c.cantidad > 0 and c.estado =1 and d.empresas_id = e.id';
		*/
		$sql='select DISTINCT a.* from tbl_pregunta a, tbl_almacen b, tbl_inventario c, tbl_empresas_has_tbl_users d, tbl_empresas e, tbl_users f where f.id='.Yii::app()->user->id.'
		and e.tipo=2 and c.almacen_id=b.id and d.users_id=f.id and e.id = b.empresas_id and c.producto_id = a.producto_id and c.cantidad > 0 and c.estado =1 and d.empresas_id = e.id';
		
	$count=Yii::app()->db->createCommand('select count(DISTINCT a.producto_id) from tbl_pregunta a, tbl_almacen b, tbl_inventario c, tbl_empresas_has_tbl_users d, tbl_empresas e, tbl_users f where f.id='.Yii::app()->user->id.'
	and e.tipo=2 and c.almacen_id=b.id and d.users_id=f.id and e.id = b.empresas_id and c.producto_id = a.producto_id and c.cantidad > 0 and c.estado =1 and d.empresas_id = e.id')->queryScalar();
	
		$dataProvider=new CSqlDataProvider($sql, array(
		  	'totalItemCount'=>$count,
		    'sort'=>array(
		        'attributes'=>array(
		             'id','pregunta','fecha',
		        ),
		  	),
		  	'pagination'=>array(
				'pageSize'=>10,
			),
		    
		));		
				
		$this->render('preguntas',array(  
			'dataProvider'=>$dataProvider, 
		));

	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Pregunta');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Pregunta;
		$model->unsetAttributes();  // clear any default values
		
		$dataProvider = $model->search(); 
		
		if(isset($_GET['Pregunta']))
			$model->attributes=$_GET['Pregunta'];

		//var_dump($dataProvider->getData());
		//Yii::app()->end();

		$this->render('admin',array(
			'model'=>$model,
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
		$model=Pregunta::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='pregunta-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
