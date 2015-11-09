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
        //$this->layout='//layouts/start'; 
		$sql="";
		$sub="";
		$otraForma="";
		$opcion2="";
		$filtroCategoria="";
		$sqlCategoria2="";
		$sqlCategoria="";
		$filtroMarca="";
		$filtroPrecio="";
		if(isset($_GET['producto']))
		{
	
                $filter['producto']=$_GET['producto'];
          
                 
			$productoPartido=explode(" ", $_GET['producto']);
			$num=count($productoPartido);

			if(isset($productoPartido[$num-1]) && isset($productoPartido[$num-2])  && isset($productoPartido[$num-3])) // funcion puede dar error
			{
												
				$variable="";
				for($i=0;$i<=$num-3;$i++)
				{	
					if($i!=$num-3)	
						$variable=$variable.$productoPartido[$i]." ";
					else	
					   $variable=$variable.$productoPartido[$i];
				}
				if(Categoria::model()->buscarCategoria($productoPartido[$num-1])!="" && $productoPartido[$num-2]=="en" && ProductoPadre::model()->buscarProducto($variable)!="")
				{
					$padre_id=ProductoPadre::model()->buscarProducto($variable);
					$otraForma=1; // bandera
					$sql="select p.id, p.nombre, min(i.precio) as menor,  p.padre_id, p.modelo, p.annoFabricacion, p.upc, p.ean, p.gtin, p.nparte, p.tlt_codigo, p.color, p.color_id, p.descripcion, p.destacado, p.estado, p.caracteristicas, p.id_seo
					 from tbl_producto p join tbl_inventario i on p.id=i.producto_id where p.padre_id=".$padre_id.""; //TODO mejorar esto, forma menos optima
				}	
			}
			if($otraForma!=1) // bandera activa
			{
					$sql="select p.id, p.nombre,  min(i.precio) as menor, p.padre_id, p.modelo, p.annoFabricacion, p.upc, p.ean, p.gtin, p.nparte, p.tlt_codigo, p.color, p.color_id, p.descripcion, p.destacado, p.estado, p.caracteristicas, p.id_seo
					 from tbl_producto p join tbl_inventario i on p.id=i.producto_id where p.nombre LIKE '%".$filter['producto']."%'"; //TODO mejorar esto, forma menos optima
			}
				



			if($filter['producto']!="") //filtros
			{
				$filter['producto'];
			}
		}
		else 
		{   $filter['producto']="";
			$sql="select p.id, p.nombre, min(i.precio) as menor,  p.padre_id, p.modelo, p.annoFabricacion, p.upc, p.ean, p.gtin, p.nparte, p.tlt_codigo, p.color, p.color_id, p.descripcion, p.destacado, p.estado, p.caracteristicas, p.id_seo from tbl_producto p where p.nombre <>''"; //TODO mejorar esto, forma menos optima 
		}
        $filter['categoria']=isset($_GET['categoria'])?$_GET['categoria']:'';
        $filter['marcas']=isset($_GET['marcas'])?$_GET['marcas']:'';

        
		if(isset($_GET['precio'])){
			$filter['precio']=$_GET['precio'];
			$filtroPrecio=explode("-", $filter['precio']);
			$filter['precioMenor']=$filtroPrecio[0];
			$filter['precioMayor']=$filtroPrecio[1];
		}else{
			$filter['precio']='';
			$filter['precioMenor']=0;
			$filter['precioMayor']=200000;
		}
		
		$order=isset($_GET['order'])?$_GET['order']:'';
        //$filter['caracteristica']=isset($_GET['caracteristica'])?$_GET['caracteristica']:''; TODO para otra entrega
        
		if(isset($filter['categoria'])){
    		if($filter['categoria']!="")//filtros
    		{
    			// $filtroCategoria=$filter['categoria'];
    			// $filtroCategoria=Categoria::model()->findByAttributes(array('nombre'=>$filtroCategoria));
    			// echo $filtroCategoria;
    
    			$filtroCategoria=$filter['categoria'];
    			$filtroCategoria=Categoria::model()->findByAttributes(array('url_amigable'=>$filtroCategoria));
    			$vector=ARRAY();
    			//$vector=Categoria::model()->buscarPadres($filtroCategoria->id, $vector); //TODO MEJORAR ESTO
    			//echo $word=Categoria::model()->incluir($vector);
    			$vector=Categoria::model()->buscarHijos($filtroCategoria->id, $vector); //TODO MEJORAR ESTO
    		    $word=Categoria::model()->incluir($vector);
    			$sqlCategoria="and p.padre_id in (select pa.id from tbl_producto_padre pa where pa.id_categoria in(".$word."))";
    			$sqlCategoria2="where pa.id_categoria in(".$word.")";
    			//var_dump($vector);
    		}
        }	

		
		if(isset($filter['marcas'])){//filtros
    		if($filter['marcas']!="")
    		{
    			$filtroMarca=explode("-", $filter['marcas']);
    			$contador=count($filtroMarca)-1;
    			if($sqlCategoria2!="") // si hay filtro de categoria
    			{
    				$sql=$sql." and p.padre_id in (select pa.id from tbl_producto_padre pa ".$sqlCategoria2." and pa.id_marca in (";
    				$opcion2=" and p.padre_id in (select pa.id from tbl_producto_padre pa ".$sqlCategoria2."  and pa.id_marca in (";
    			}
    			else 
    			{
    				$sql=$sql." and p.padre_id in (select pa.id from tbl_producto_padre pa where pa.id_marca in (";
    				$opcion2=" and p.padre_id in (select pa.id from tbl_producto_padre pa where pa.id_marca in (";
    			}
    
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
        }else{
    		    $filter['marcas']="";
    		}
		
		
		if($filter['precio']!="")//filtros
		{

			if($opcion2=="")
			{
				if($sqlCategoria!="")
				{
					$opcion2=$sqlCategoria;
				}
			}
			if($otraForma!=1) // si es busqueda por variacion
			{	
				if($opcion2!="")
					$sub="select i.id, min(i.precio) as menor, i.costo, i.cantidad, i.almacen_id, i.notaCondicion, i.garantia, i.producto_id, i.estado, i.condicion, i.sku, i.numFabricante, i.metodoEnvio from tbl_inventario i where i.producto_id in (select p.id from tbl_producto p where p.nombre LIKE '%".$filter['producto']."%' ".$opcion2.") and i.precio between ".$filtroPrecio[0]." and ".$filtroPrecio[1]."";
				else
					$sub="select i.id, min(i.precio) as menor, i.costo, i.cantidad, i.almacen_id, i.notaCondicion, i.garantia, i.producto_id, i.estado, i.condicion, i.sku, i.numFabricante, i.metodoEnvio from tbl_inventario i where i.producto_id in (select p.id from tbl_producto p where p.nombre LIKE '%".$filter['producto']."%') and i.precio between ".$filtroPrecio[0]." and ".$filtroPrecio[1]."";
			}
			else // si es busqueda por producto padre
			{
				if($opcion2!="")
					$sub="select i.id, min(i.precio) as menor, i.costo, i.cantidad, i.almacen_id, i.notaCondicion, i.garantia, i.producto_id, i.estado, i.condicion, i.sku, i.numFabricante, i.metodoEnvio from tbl_inventario i where i.producto_id in (select p.id from tbl_producto p where p.padre_id='".$padre_id."' ".$opcion2.") and i.precio between ".$filtroPrecio[0]." and ".$filtroPrecio[1]."";
				else
					$sub="select i.id, min(i.precio) as menor, i.costo, i.cantidad, i.almacen_id, i.notaCondicion, i.garantia, i.producto_id, i.estado, i.condicion, i.sku, i.numFabricante, i.metodoEnvio from tbl_inventario i where i.producto_id in (select p.id from tbl_producto p where p.padre_id='".$padre_id."') and i.precio between ".$filtroPrecio[0]." and ".$filtroPrecio[1]."";
			}
			
			//echo $sub;
		}
		if($filtroMarca=="" && $filtroPrecio=="" && $filtroCategoria!="") // si solo hay filtro de categoria
		{
			 $sql=$sql.$sqlCategoria;

		}
		//TODO caracteristica para proxima entrega
	/*	if($filter['caracteristica']!="")//filtros
		{
			echo $filter['caracteristica'];
		}*/
		//echo $sql;echo $sub;
		
		
		
		if($sql!="") /// GROUP BY
		{
			$or=" group by p.id";
			$sql=$sql.$or;	
		}
		if($sub!="")
		{
			$or=" group by i.producto_id";
			$sub=$sub.$or;	
		}
		
		if($order!="")
		{ 
				if($order=="nombre-asc")
				{
					$sql=$sql." order by p.nombre";
				}
				else
				{
						if($order=="mayorPrecio-asc")
						{
							$sql=$sql." order by menor desc";
							$sub=$sub." order by menor desc";
						}
						else 
						{
							$sql=$sql." order by menor asc";
							$sub=$sub." order by menor asc";
						}
				}	
		}		


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
		
		
		if(isset( $_GET['display']))
		{
			$list= $_GET['display'];
		}
		else 
		{
			$list=0;
		}
		//echo $sql;
		//echo $sub;
		
       $this->render('store', array('categorias'=>Categoria::model()->categoriasEnExistencia,'list'=>$list,'filter'=>$filter, 'model'=>$model, 'model2'=>$model2, 'order'=>$order));
    }
	
}
