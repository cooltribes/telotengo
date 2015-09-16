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
				'actions'=>array('index','filtrar','storefront'), //TODO acomodar esto cuando se tengan los usuarios
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
		$sql="";
		$sub="";
		$opcion2="";
		$filtroCategoria="";
		if(isset($_GET['producto']))
		{
			$filter['producto']=$_GET['producto'];
			$sql="select * from tbl_producto where nombre LIKE '%".$filter['producto']."%'"; //TODO mejorar esto, forma menos optima
			if($filter['producto']!="") //filtros
			{
				$filter['producto'];
			}
		}
        $filter['categoria']=isset($_GET['categoria'])?$_GET['categoria']:'';
        $filter['marcas']=isset($_GET['marcas'])?$_GET['marcas']:'';
        $filter['precio']=isset($_GET['precio'])?$_GET['precio']:'';
        //$filter['caracteristica']=isset($_GET['caracteristica'])?$_GET['caracteristica']:''; TODO para otra entrega
		

			
		if($filter['categoria']!="")//filtros
		{
			// $filtroCategoria=$filter['categoria'];
			// $filtroCategoria=Categoria::model()->findByAttributes(array('nombre'=>$filtroCategoria));
			// echo $filtroCategoria;
		}
		
		if($filter['marcas']!="")//filtros
		{
			$filtroMarca=explode("-", $filter['marcas']);
			$contador=count($filtroMarca)-1;
			$sql=$sql." and padre_id in (select id from tbl_producto_padre where id_marca in (";
			$opcion2=" and padre_id in (select id from tbl_producto_padre where id_marca in (";
			$i=0;	
			foreach($filtroMarca as $marca)
			{
				$sql=$sql.$marca;
				$opcion2=$opcion2.$marca;
				if($contador!=$i)
				{
					$sql=$sql.",";
					$opcion2=$opcion2.",";
				}
			$i++;
			}
			$sql=$sql."))";
			$opcion2=$opcion2."))";
		}
		if($filter['precio']!="")//filtros
		{
			$filtroPrecio=explode("-", $filter['precio']);	
			$filtroPrecio[0];
			$filtroPrecio[1];
			if($opcion2!="")
				$sub="select * from tbl_inventario where producto_id in (select id from tbl_producto where nombre LIKE '%".$filter['producto']."%' ".$opcion2.") and precio between ".$filtroPrecio[0]." and ".$filtroPrecio[1]."";
			else
				$sub="select * from tbl_inventario where producto_id in (select id from tbl_producto where nombre LIKE '%".$filter['producto']."%') and precio between ".$filtroPrecio[0]." and ".$filtroPrecio[1]."";
			
			//echo $sub;
		}
		
		//TODO caracteristica para proxima entrega
	/*	if($filter['caracteristica']!="")//filtros
		{
			echo $filter['caracteristica'];
		}*/

		if($sql!="")
		{
			//echo $sql;
			$model="";
			//echo $sql;
			$model=Yii::app()->db->createCommand($sql)->queryAll();
		}
			
		else
		{
			$model="";
		}
		
		
		
		if($sub!="") //TODO mejorar esto substiuyo la consulta ya que las relaciones estaban mal hechas
		{
			//echo $sql;
			$model2="";
			//echo $sub;
			$model2=Yii::app()->db->createCommand($sub)->queryAll();
		}
			
		else
		{
			$model2="";
		}
			
       $this->render('store', array('categorias'=>Categoria::model()->categoriasEnExistencia,'list'=>false,'filter'=>$filter, 'model'=>$model, 'model2'=>$model2));
    }
	
}