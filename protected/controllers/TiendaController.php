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
				'actions'=>array(), //TODO acomodar esto cuando se tengan los usuarios
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','filtrar','storefront', 'buscarCategoria'),
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
        if(!Yii::app()->user->id)
             throw new CHttpException(403,'No está autorizado a visualizar este contenido');
        $filter=$_GET;
        $condition = array();
        $r1=false;
        $query="";
        $variablePrecio=0;
        $minPrice=0;
        $maxPrice=0;
        if(!isset($_GET['page'])){
            unset(Yii::app()->session['store_condition']);
            if(isset($_GET['producto']))
            {
                $validacion=Funciones::verificarCadena($_GET['producto']);
                $_GET['producto']=addslashes($_GET['producto']); 
               /* $condition['productos']=Funciones::long_query($_GET['producto'],"padre.nombre")." OR ";
                $condition['productos'].=Funciones::long_query($_GET['producto'],"marca.nombre")." OR ";  
                $condition['productos'].=Funciones::long_query($_GET['producto'],"producto.nombre"); */
                if($validacion==false)
                {
                    $condition['productos']="producto.nombre like '%".$_GET['producto']."%' ";
                }
                else
                {
                    $variables=explode("++", $validacion);
                    $condition['productos']="producto.nombre like '%".$variables[0]."%' or padre.nombre like '%".$variables[1]."%'";
                }
                $query=$query.$condition['productos'];
                $r1=true;
            }
            if(isset($_GET['marcas']))
            {
                if(isset($_GET['producto']))
                     $query=$query." AND ";
                $_GET['marcas']=addslashes($_GET['marcas']);             
                $condition['marcas']= Funciones::inCondition(str_replace('-',',', $_GET['marcas']),'marca.id');
                $query=$query.$condition['marcas'];
                $r1=true;
            }
            else{
                $filter['marcas']='';
            }
            if(isset($_GET['categoria']))
            {
                if(isset($_GET['marcas'])||isset($_GET['producto']))
                    $query=$query." AND ";     
                $categoria=Categoria::model()->findByAttributes(array('url_amigable'=>$_GET['categoria']));
                if($categoria){
                    $hijos=$categoria->buscarHijos($categoria->id);
                    $implode=implode(',',$hijos);
       
                    if(count($hijos)>1)
                        $condition['categoria']=Funciones::inCondition($implode,'categoria.id');
                    else
                        $condition['categoria']='categoria.id = '.$categoria->id;
                    
                    $query=$query.$condition['categoria']; 
                    
                }
                $r1=true;            
            }else{
                 $filter['categoria']='';
            }
            if($r1){
                if($query=="")
                {
                    $sql="select producto.id from tbl_producto producto JOIN tbl_producto_padre padre ON padre.id=producto.padre_id JOIN tbl_marca marca ON marca.id=padre.id_marca JOIN tbl_categoria categoria ON categoria.id=padre.id_categoria WHERE producto.aprobado = 1 AND producto.estado = 1 AND(0)";
                }
                else
                {
                   $sql="select producto.id from tbl_producto producto JOIN tbl_producto_padre padre ON padre.id=producto.padre_id JOIN tbl_marca marca ON marca.id=padre.id_marca JOIN tbl_categoria categoria ON categoria.id=padre.id_categoria WHERE producto.aprobado = 1 AND producto.estado = 1 AND(".$query.") "; 
                }
                  
                $r1=Yii::app()->db->createCommand($sql)->queryColumn();           
               
            }
            else{
                $sql="select producto.id from tbl_producto producto JOIN tbl_inventario inventario ON inventario.producto_id=producto.id WHERE producto.aprobado = 1 AND producto.estado = 1 AND inventario.cantidad > 0 ";  
                $r1=Yii::app()->db->createCommand($sql)->queryColumn();
            }
                            
            if(isset($_GET['precio']))
            {
                $precios=explode('-',$filter['precio']);
               $maxPrice=$filter['precioMayor']=$precios[1];
               $minPrice= $filter['precioMenor']=$precios[0];
                if($filter['precioMayor']==0 || $filter['precioMenor']==0)
                {
                    $filter['precioMayor']=$maxPrice;
                    $filter['precioMenor']=$minPrice;
                }
                $condition['precios']=" precio >= ".$filter['precioMenor']." AND "."precio <= ".$filter['precioMayor'];
                $sql="select distinct(producto.id) from tbl_inventario inventario JOIN tbl_producto producto ON producto.id=inventario.producto_id WHERE producto.estado = 1 AND producto.aprobado = 1 AND ".$condition['precios'];
     
            }
            else{
                 $sql="select distinct(producto.id) from tbl_inventario inventario JOIN tbl_producto producto ON producto.id=inventario.producto_id WHERE producto.estado = 1 AND producto.aprobado = 1 AND inventario.cantidad > 1";
                  $filter['precio']='';
                  $variablePrecio=1;
            }
            $r2=Yii::app()->db->createCommand($sql)->queryColumn();
         
             $result=implode(',',array_intersect($r1,$r2));

            if($variablePrecio==1) //calcular el valor minimo y maximo de los precios para el filtro
            {
               
                $vec=explode(",", $result);
                if(count($vec)>1)
                {
                    foreach($vec as $vecs) //mostrar =1, para mostrar los que tienen inventario o se acabo el inventario por ventas
                    {
                        $sqls="select min(precio) as minimo from tbl_inventario where mostrar=1 and producto_id=".$vecs;
                        $consulta=Yii::app()->db->createCommand($sqls)->queryRow();
                        if($minPrice==0)
                        {
                            $minPrice=$consulta['minimo'];
                        }
                        else
                        {
                            if($consulta['minimo']<$minPrice)
                            {
                                $minPrice=$consulta['minimo'];
                            }
                        }

                        if($maxPrice==0)
                        {
                            $maxPrice=$consulta['minimo'];
                        }
                        else
                        {
                            if($consulta['minimo']>$maxPrice)
                            {
                                $maxPrice=$consulta['minimo'];
                            }
                        }
                    }  
                }
                else
                {
                    if($result!="") //mostrar =1, para mostrar los que tienen inventario o se acabo el inventario por ventas
                    {
                        $minPrice=0;
                        $sqls="select min(precio) as minimo from tbl_inventario where mostrar=1 and producto_id=".$result;
                        $consulta=Yii::app()->db->createCommand($sqls)->queryRow();
                        $maxPrice=$consulta['minimo'];  
                    }
                    else
                    {
                        $minPrice=0;
                        $maxPrice=100000; //estandar que se puede modificar
                    }
                }

                $filter['precioMayor']=$maxPrice;
                $filter['precioMenor']=$minPrice;

            }
            
         
            Yii::app()->session['store_condition']=(strlen($result)>0)?$result:0;
           
            $page=0;            
        }else{
            $page=$_GET['page'];
        }
        $filter['precioMayor']=$maxPrice;
        $filter['precioMenor']=$minPrice;             
        $criteria=new CDbCriteria;            
        $criteria->addCondition(" t.id IN (".Yii::app()->session['store_condition'].")");
        if(isset($_GET['order'])){
            $criteria->with='inventarios';
            $criteria->order='min(inventarios.precio) '.$_GET['order'];
            $criteria->group="t.id"; 
            $criteria->together;
        }
        $dataProvider= new CActiveDataProvider("Producto", array(
        'criteria'=>$criteria,
        'pagination'=>array('pageSize'=>9),
         ));
          if(isset( $_GET['display']))
        {
            $list= $_GET['display'];
        }
        else 
        {
            $list=0;
        }
        
          if(isset( $_GET['order']))
        {
            $order= $_GET['order'];
        }
        else 
        {
            $order="";
        }
		 	 
       $this->render('store', array('maxPrice'=>$filter['precioMayor'],'minPrice'=>$filter['precioMenor'],'categorias'=>Categoria::model()->categoriasEnExistencia,'list'=>$list,'filter'=>$filter,'order'=>$order, 'dataProvider'=>$dataProvider));
    }

	public function actionBuscarCategoria()
	{
		$id=$_POST['filtroBusqueda'];
		echo Categoria::model()->findByPk($id)->url_amigable;
	}
    
    public function actionIndex2(){       
        
         
         
         //CODIGO ANTERIOR 
         
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
        $padre="";
        if(isset($_GET['producto']))
        {
    
            $filter['producto']=$_GET['producto'];
            $productoPartido=explode("(", $_GET['producto']);       
            $num=count($productoPartido);
            $i=1;
            $produc="";
            $cadena="";
            
            foreach($productoPartido as $prod) /// sirve con todos, probar con el s6 
            {
                if($i==1)   
                {
                    $produc=$prod;
                }
                else
                {
                    $cadena=str_replace(")", "", $prod);    
                    if(!Categoria::model()->findByAttributes(array('nombre'=>$cadena))) // sirve con dos parentesis
                    {
                         $prod="(".$prod;
                         $produc=$produc.$prod;
                    }
                    else 
                    {
                        $cate=Categoria::model()->findByAttributes(array('nombre'=>$cadena));
                        $var=trim($produc);
                        if(isset($_GET['categoria']) && !ProductoPadre::model()->findByAttributes(array('nombre'=>$var)))
                        {
                            if($_GET['categoria']!="") // si el filtro no es vacio
                                if($_GET['categoria']==$cate->url_amigable)
                                    $filter['producto']=trim($produc);
                        }
                        else
                        {
                            $var=trim($produc);
                            if(ProductoPadre::model()->findByAttributes(array('nombre'=>$var))) // si esta bien, entre; del resto es invento del usuario
                            {
                                $padre=ProductoPadre::model()->findByAttributes(array('nombre'=>$var));
                                $padre_id=ProductoPadre::model()->buscarProducto($var);
                                $otraForma=1;
                            }
                        }   
                    }
                }   
                $i++;
            }
            //echo $filter['producto'];
            //echo $produc;

            /*if(isset($productoPartido[$num-1]) && isset($productoPartido[$num-2])  && isset($productoPartido[$num-3])) // funcion puede dar error
            {
                                                
                $variable="";

                for($i=0;$i<=$num-3;$i++)
                {   
                    if($i!=$num-3)  
                        $variable=$variable.$productoPartido[$i]." ";
                    else    
                       $variable=$variable.$productoPartido[$i];
                }
                
                if($_GET['categoria']=="")
                {
                    $otraForma=1;
                }
                else 
                {
                    $otraForma=0;
                }
                if(Categoria::model()->buscarCategoria($productoPartido[$num-1])!="" && $productoPartido[$num-2]=="en" && ProductoPadre::model()->buscarProducto($variable)!="" && $otraForma==1)
                {
                    $padre_id=ProductoPadre::model()->buscarProducto($variable);
                    $otraForma=1; // bandera
                    $sql="select p.id, p.nombre, min(i.precio) as menor,  p.padre_id, p.modelo, p.annoFabricacion, p.upc, p.ean, p.gtin, p.nparte, p.tlt_codigo, p.color, p.color_id, p.descripcion, p.destacado, p.estado, p.caracteristicas, p.id_seo
                     from tbl_producto p join tbl_inventario i on p.id=i.producto_id where p.padre_id=".$padre_id.""; //TODO mejorar esto, forma menos optima
                }   
            }*/
            if($otraForma!=1) // bandera activa
            {
                //echo "basta de";
                    $sql="select p.id, p.nombre,  min(i.precio) as menor, p.padre_id, p.modelo, p.annoFabricacion, p.upc, p.ean, p.gtin, p.nparte, p.tlt_codigo, p.color, p.color_id, p.descripcion, p.destacado, p.estado, p.caracteristicas, p.id_seo
                     from tbl_producto p join tbl_inventario i on p.id=i.producto_id where p.nombre LIKE '%".$filter['producto']."%' "; //TODO mejorar esto, forma menos optima
            }
            else 
            {
                $sql="select p.id, p.nombre,  min(i.precio) as menor, p.padre_id, p.modelo, p.annoFabricacion, p.upc, p.ean, p.gtin, p.nparte, p.tlt_codigo, p.color, p.color_id, p.descripcion, p.destacado, p.estado, p.caracteristicas, p.id_seo
                     from tbl_producto p join tbl_inventario i on p.id=i.producto_id where p.padre_id='".$padre->id."' "; 
            }
                



            if($filter['producto']!="") //filtros
            {
                $filter['producto'];
            }
        }
        else 
        {   $filter['producto']="";
            $sql="select p.id, p.nombre, min(i.precio) as menor,  p.padre_id, p.modelo, p.annoFabricacion, p.upc, p.ean, p.gtin, p.nparte, p.tlt_codigo, p.color, p.color_id, p.descripcion, p.destacado, p.estado, p.caracteristicas, p.id_seo from tbl_producto p join tbl_inventario i on p.id=i.producto_id where p.nombre <>''"; //TODO mejorar esto, forma menos optima 
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
            $filter['precioMayor']=5000000;
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
                if($word=="")
                    $word=0; ///////////// si no existe ningun producto con esa categoria
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
    /*  if($filter['caracteristica']!="")//filtros
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
                            if($sql!="")    
                                $sql=$sql." order by menor desc";
                            if($sub!="")
                                $sub=$sub." order by menor desc";
                        }
                        else 
                        {
                            if($sql!="")        
                                $sql=$sql." order by menor asc";
                            if($sub!="")
                                $sub=$sub." order by menor asc";
                        }
                }   
        }       
        if($sql!="")
        {
            //echo $sql;
            $model="";
            #echo "<br>";
            $model=Yii::app()->db->createCommand($sql)->queryAll();
            #var_dump($model);
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
         
         
         
         
         
         
    }
    
    
	
}
