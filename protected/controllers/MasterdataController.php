<?php

class MasterdataController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('upload','misMasterdata','detalleUsuario'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('detalle','setPadre','admin','setColor'),
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
	public function actionUpload(){
         $producto = new Producto;
         $summary=0;
         $tags=$producto->getFileTags("all");
         $resumen=null;
                      
         if(isset($_FILES["validar"])){
            if(is_file($_FILES["validar"]["tmp_name"])){ 
                $resumen=$this->validarMasterData(Yii::app()->yexcel->readActiveSheet($_FILES["validar"]["tmp_name"]));             
            }
            else{
                $resumen=array("errores"=>1,"resumen"=>"No se seleccionó un archivo valido");
            }
            $summary=1; 
         }
         
          
        if(isset($_FILES["cargar"])){
            if(is_file($_FILES["cargar"]["tmp_name"])){
                $tempSheet=Yii::app()->yexcel->readActiveSheet($_FILES["cargar"]["tmp_name"]);
                $resumen=$this->validarMasterData($tempSheet,true);
                if(!$resumen["unproccesed"]){
                    $inicial = basename($_FILES["cargar"]["name"]);        
                    $ext = pathinfo($inicial,PATHINFO_EXTENSION);
                    $master= new Masterdata;                    
                    $master->filas=count($tempSheet)-1;  
                    $master->uploaded_at=date("Y-m-d H:i:s");
                    $master->uploaded_by=Yii::app()->user->id;
                    $master->errors=$resumen['errores'];
                    if($master->save()){
                        $master->refresh();
                        $path="/docs/xlsMasterData/".$master->id.".".$ext;
                        $target_file = Yii::getPathOfAlias('webroot').$path;
                        if(move_uploaded_file($_FILES["cargar"]["tmp_name"], $target_file)){
                            $master->path=$path;
                            if($master->save()){
                                if(count($resumen["saved"])>0)
                                    Producto::model()->updateAll(array('masterdata_id'=>$master->id),"id IN (".implode(",",$resumen["saved"]).")");
                            }                                   
                        }
                    }
                }
                               
                
            }
            else
            {
                $resumen=array("errores"=>1,"resumen"=>"No se seleccionó un archivo valido");
            }            
            
            $summary=2;
        }           
            
        
         $this->render('upload',array("resumen"=>$resumen,"summary"=>$summary));
    }
    public function validarMasterData($excel,$save=false){
        $tags=Producto::model()->getFileTags("columns");
        #print_r($tags); echo"<br/><br/>"; print_r($excel[1]);
        $saved=array();
        if(!($tags===array_slice($excel[1],0,20))){
            return array("errores"=>1,"resumen"=>"Encabezados no coinciden con la plantilla","unproccesed"=>1,"saved"=>$saved);
        }
        unset($excel[1]);
        if(count($excel)<1){
            return array("errores"=>1,"resumen"=>"Archivo no contiene registros","unproccesed"=>1,"saved"=>$saved);
        }
        $resumen="";
        $errores=0;        
        foreach($excel as $key=>$fila){
            $error=false;
            $resumen.="Producto #".($key-1).": <br/><ul>";
            $exists=Producto::model()->findByAttributes(array('nombre'=>$fila["E"]));
            if($exists){
                $resumen.='<li>Ya existe un producto con el nombre <a href="'.$this->createUrl('producto/seleccion',array('query'=>$exists->nombre)).'" class="blueLink" target="_blank"><u>'.$exists->nombre.'</u></a></li>';
                $errores++;
                $error=true;
           
            }
            if($fila["A"]==""&&$fila["B"]==""&&$fila["C"]==""&&$fila["D"]==""){
                $resumen.="<li>Debe presentar al menos un valor en los campos".$tags["A"].", ".$tags["B"].", ".$tags["C"]." y ".$tags["D"]." <li/>";
                $errores++;$error=true;                
            }
            if($fila["F"]==""||$fila["G"]==""||$fila["E"]==""||$fila["H"]==""){
                $resumen.="<li>Los campos ".$tags["F"].", ".$tags["G"].", ".$tags["E"]." y ".$tags["H"]." son obligatorios</li>";
                $errores++;$error=true;
            }
            if(strlen($fila["J"])>250||strlen($fila["K"])>250||strlen($fila["L"])>250||strlen($fila["M"])>250){
                $resumen.="<li>Los campos Característica deben tener máximo 250 caracteres(".strlen($fila["J"]).",".strlen($fila["K"]).",".strlen($fila["L"]).",".strlen($fila["M"]).")</li>";
                $errores++;$error=true;
            }
            $resumen.="</ul>";
            if(!$error){
                if($save)
                {
                   $producto= new Producto;
                        
                        //$producto->sku=$fila["A"];
                        $producto->upc=$fila["A"];
                        $producto->ean=$fila["B"];
                        $producto->gtin=$fila["C"];
                        $producto->nparte=$fila["D"];
                        if(strpos(strtoupper($fila["E"]),strtoupper($fila["F"]))==-1)
                            $producto->nombre=$fila["F"]." | ".$fila["E"];
                        else
                            $producto->nombre=$fila["E"];
                        $producto->modelo=$fila["G"];
                        $color=Color::model()->findByAttributes(array('nombre'=>strtoupper($fila['H'])));
                        if($color){
                            $producto->color_id=$color->id;
                        }
                        else
                            $producto->color_id=0;                             
                        $producto->color=$fila["H"];/* LA H */
                        $producto->descripcion=$fila["I"];
                        $producto->caracteristicas=implode("*-*",array($fila["J"],$fila["K"],$fila["L"],$fila["M"]));
                        $producto->padre_id=0;
                        if($producto->save()){
                            $producto->refresh();
                            $saveMongo=false;
                            $mongoData=array();
                            if(strlen(str_replace(" ","",$fila["N"]))>0){
                                $mongoData["Longitud"]=$fila["N"];
                                $mongoData["Longitud*-*UNIDAD"]=1;
                                $saveMongo=true;
                            }  
                            if(strlen(str_replace(" ","",$fila["O"]))>0){
                                $mongoData["Ancho"]=$fila["O"];
                                $mongoData["Ancho*-*UNIDAD"]=1;
                                $saveMongo=true;
                            }
                            if(strlen(str_replace(" ","",$fila["P"]))>0){
                                $mongoData["Altura"]=$fila["P"];
                                $mongoData["Altura*-*UNIDAD"]=1;
                                $saveMongo=true;
                            }  
                            if(strlen(str_replace(" ","",$fila["Q"]))>0){
                                $mongoData["Peso"]=$fila["Q"];
                                $mongoData["Peso*-*UNIDAD"]=4;
                                $saveMongo=true;
                            }
    
                            if($saveMongo)
                                $this->saveToMongo($producto->id,$mongoData);                             
                                                       
                            $seo = new Seo;
                            $seo->descripcion = $fila["R"]; 
                            $seo->tags = $fila["S"]; 
                            $seo->amigable = $fila["T"];
                            if($seo->save()){
                                $seo->refresh();
                                $producto->id_seo=$seo->id;
                                $producto->created_at=date("Y-m-d H:i:s");
                                $producto->user_id=Yii::app()->user->id;
                                if($producto->save())
                                    $resumen.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Guardado con éxito<br/><br/>";
                                    array_push($saved,$producto->id);
                            }
                                          
                        }else{
                             $resumen.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Error en guardado<br/><br/>";
                        }
                }else{
                    $resumen.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Validado con éxito<br/><br/>";
                }
            }
        }
        return array("errores"=>$errores,"resumen"=>$resumen,"unproccesed"=>0,"saved"=>$saved);   
    }

    public function actionDetalle($id){
        $master=Masterdata::model()->findByPk($id);
        
        if($master){
            
            $productos=Producto::model()->searchByMasterData($master->id);
            $this->render('detalleMD',array("model"=>$master,"productos"=>$productos));
        }
             
        else
            throw new CHttpException(404,'The requested page does not exist.');
        
    }
     public function actionDetalleUsuario($id){
        $master=Masterdata::model()->findByPk($id);
        
        if($master){
            
            $productos=Producto::model()->searchByMasterData($master->id);
            $this->render('detalleMDUser',array("model"=>$master,"productos"=>$productos));
        }
             
        else
            throw new CHttpException(404,'The requested page does not exist.');
        
    }
    
    public function saveToMongo($id,$data){
        
        $connection = new MongoClass();
        if(Funciones::isDev())
        {
            $document = $connection->getCollection('ejemplo');  //DEVELOP
        }   
        else
        {
            if(Funciones::isStage())
                $document = $connection->getCollection('stage');    //STAGE
            else
                $document = $connection->getCollection('produccion'); // produccion
        } 
            
        if(count($data)>0)
        {            
            $data['producto']=$id;
            $prueba = array("producto"=>$id); 
            $user = $document->findOne($prueba); // vamos a buscar si existe el registro            
            if(!is_null($user)) // si no existe el registro, inserte uno nuevo
            {
                $document->remove(array("producto"=>$id));  //quito la coleccion
            }
            if($document->insert($data))
                return true;
            else
                return false; 
        }
         
    }
    
    public function actionSetPadre()
    {
        $producto = Producto::model()->findByPk($_POST['id']);
        $padre = ProductoPadre::model()->findByPk($_POST['padre']);
        if($padre&&$producto){
            $result=array();
            $producto->padre_id=$padre->id;
            if($producto->save()){
                    $producto->refresh();
                   $result['status']="ok";
                    $result['html']=$producto->padre->nombre;
            }else{
                $result['status']="error";
            }
        }else{
                $result['status']="error";
            }
        echo json_encode($result);
        
    }
 
    
    public function actionAdmin()
    {
        $model = new Masterdata;
        $model->unsetAttributes();  // clear any default values
        $bandera=false;
        $dataProvider=Masterdata::model()->all;
        
                /* Para mantener la paginacion en las busquedas */
        if(isset($_GET['ajax']) && isset($_SESSION['searchMD']) && !isset($_POST['query'])){
            $_POST['query'] = $_SESSION['searchMD'];
            $bandera=true;
        }

        /* Para buscar desde el campo de texto */
        if (isset($_POST['query'])){
            #echo "select user_id from tbl_profiles where ".Funciones::long_query($_POST['query'], "first_name")." OR ".Funciones::long_query($_POST['query'], "last_name");
            $bandera=true;
            unset($_SESSION['searchMD']);
            $_SESSION['searchMD'] = $_POST['query'];
            $dataProvider = $model->getAll($_POST['query']);
            
        }   

        if($bandera==FALSE){
            unset($_SESSION['searchMD']);
        }
            
        $this->render('admin',array(
            'model'=>$model,
            'dataProvider'=>$dataProvider,
        ));
    }

     public function actionMisMasterdata()
    {
        $model = new Masterdata;
        $user = User::model()->findByPk(Yii::app()->user->id);
        $model->unsetAttributes();  // clear any default values
        $bandera=false;
        $dataProvider=$model->getByEmpresa($user->empresa->getStaff($user->empresa->id,false),"");
        
                /* Para mantener la paginacion en las busquedas */
        if(isset($_GET['ajax']) && isset($_SESSION['searchMD']) && !isset($_POST['query'])){
            $_POST['query'] = $_SESSION['searchMD'];
            $bandera=true;
        }

        /* Para buscar desde el campo de texto */
        if (isset($_POST['query'])){
            #echo "select user_id from tbl_profiles where ".Funciones::long_query($_POST['query'], "first_name")." OR ".Funciones::long_query($_POST['query'], "last_name");
            $bandera=true;
            unset($_SESSION['searchMD']);
            $_SESSION['searchMD'] = $_POST['query'];
            $dataProvider = $model->getByEmpresa($user->empresa->getStaff($user->empresa->id,false),$_POST['query']);
            
        }   

        if($bandera==FALSE){
            unset($_SESSION['searchMD']);
        }
            
        $this->render('misMasterdata',array(
            'model'=>$model,
            'user'=>$user,
            'dataProvider'=>$dataProvider,
        ));
    }
public function actionSetColor()
     {
         $producto = Producto::model()->findByPk($_POST['id']);
         $color = Color::model()->findByPk($_POST['color']);
         if($color&&$producto){
             $result=array();
            $producto->color_id=$color->id;
             if($producto->save()){
                     $producto->refresh();
                    $result['status']="ok";
                     $result['html']=$producto->colore->nombre."<br/><small><b>Tono: </b>".$producto->color."</small>";
             }else{
                 $result['status']="error";
             }
         }else{
                 $result['status']="error";
             }
         echo json_encode($result);
        
         
         
     }
}
