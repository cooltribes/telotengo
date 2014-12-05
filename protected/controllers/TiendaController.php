<?php

class TiendaController extends Controller
{
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','filtrar','storefront'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(), 
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionStorefront()
	{
		if(isset($_GET['alias'])){
			$empresa = Empresas::model()->findByAttributes(array('url'=>$_GET['alias']));
			Yii::app()->session['empresa'] = $empresa->id;
		}
		$producto = new Producto;
		$dataProvider = $producto->productosEmpresa($empresa->id);
		
		$rangos = Inventario::model()->getLimites();
		
		$this->render('storefront',array(
			'dataProvider'=>$dataProvider,
			'rangos'=>$rangos,
			'empresa'=>$empresa,
		));
	}
	
	public function actionIndex()
	{
		$producto = new Producto;
		$producto->unsetAttributes();  
		
		$producto->estado = 1;
		// $producto->destacado = 1;
		
		$dataProvider = $producto->search();
		
		$rangos = Inventario::model()->getLimites();
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'rangos'=>$rangos,
		));
	}
	
	// Action para filtrar en tienda
	public function actionFiltrar()
	{
		$rangos = Inventario::model()->getLimites();
		$producto = new Producto;
		$producto->unsetAttributes();  
		// $producto->destacado = 1; 
		$producto->estado = 1;
		
			if (isset($_POST['categoria']) && $_POST['categoria']!="todas"){ // categorias
				$producto->categoria_id = $_POST['categoria'];				
				Yii::app()->getSession()->add('categoria', $_POST['categoria']);
			}
			
			if (isset($_POST['marca']) ){ // marcas
				$producto->marca_id = $_POST['marca'];				
				Yii::app()->getSession()->add('marca', $_POST['marca']); 
			}
			
			if (isset($_POST['precio'])) // filtro por rango de precios
			{	if($_POST['precio']<4){
					Yii::app()->session['max']=$rangos[$_POST['precio']]['max'];
					Yii::app()->session['min']=$rangos[$_POST['precio']]['min'];
					Yii::app()->session['p_index']=$_POST['precio'];
				}
				else{
					if(isset(Yii::app()->session['p_index'])){
						unset(Yii::app()->session['p_index']);
					}
				}				
					
			}
				
			if( isset($_GET['Producto_page']) )
			{
				if ( Yii::app()->getSession()->get('categoria') )
					$producto->categoria_id = Yii::app()->getSession()->get('categoria');
					
				if ( Yii::app()->getSession()->get('nombre') )
					$producto->nombre = Yii::app()->getSession()->get('nombre');
				
				$todos = array();
				$todos = $this->getAllChildren(Categoria::model()->findAllByAttributes(array("id_padre"=>$producto->categoria_id)));
				$categorias = Categoria::model()->findAllByAttributes(array("id_padre"=>$producto->categoria_id));	
				$dataProvider = $producto->busqueda($todos);
		
				$this->render('index',
				array('index'=>$producto,
				'dataProvider'=>$dataProvider,'categorias'=>$categorias,
				));	
			
			}
			
			$todos = array();
			$todos = $this->getAllChildren(Categoria::model()->findAllByAttributes(array("id_padre"=>$producto->categoria_id)));
	
			$dataProvider = $producto->busqueda($todos);
	
			$this->render('index',
				array('dataProvider'=>$dataProvider,'rangos'=>$rangos,
			));	
	}

	public function getAllChildren($models){
		$items = array();
		foreach($models as $model){
			if (isset($model->id)){
				$items[] = $model->id;
			 	if($model->hasChildren()){
                        $items= CMap::mergeArray($items,$this->getAllChildren($model->getChildren()));
                }
			}
		}
		return $items;
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