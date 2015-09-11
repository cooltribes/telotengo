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
	
	public function actionIndexOLD()
	{	
		
		$producto = new Producto;
		$producto->unsetAttributes();  
		
		$producto->estado = 1;  // solo activos

		if(isset($_POST['textobuscado'])){ // viene de la busqueda general
			#echo $_POST['busqueda'];
			#Yii::app()->end();

			$producto->nombre = $_POST['busqueda'];
			Yii::app()->getSession()->add('nombrebusqueda', $_POST['busqueda']);
			$dataProvider = $producto->busquedaPrincipal();

			$rangos = Inventario::model()->getLimitesTexto();
		}else{
			#echo $producto->nombre."<br>";
			$producto->nombre = "";
			unset(Yii::app()->session['nombrebusqueda']);
			$dataProvider = $producto->search();

			$rangos = Inventario::model()->getLimites();
		}
		
		
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
			
			if (isset(Yii::app()->session['nombrebusqueda'])) { // busqueda
				$producto->nombre = Yii::app()->session['nombrebusqueda'];
				$rangos = Inventario::model()->getLimitesTexto();

			}

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
				'dataProvider'=>$dataProvider,'categorias'=>$categorias,'rangos'=>$rangos,
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
	 

	public function actionIndex(){
        $this->layout='//layouts/start'; 
        $filter['categoria']=isset($_GET['categoria'])?$_GET['categoria']:'';
        $filter['marcas']=isset($_GET['marcas'])?$_GET['marcas']:'';
        $filter['precio']=isset($_GET['precio'])?$_GET['precio']:'';
        $filter['caracteristica']=isset($_GET['caracteristica'])?$_GET['caracteristica']:'';


       $this->render('store', array('categorias'=>Categoria::model()->categoriasEnExistencia,'list'=>false,'filter'=>$filter));
    }
}