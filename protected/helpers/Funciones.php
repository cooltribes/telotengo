<?php
class Funciones {
    
    public static function cleanUrlSeo($string){
       $string = strtr($string,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ',
        'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'); 
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
       $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.    
       return strtolower(preg_replace('/-+/', '-', $string));
    }    
     
    public static function stripAccents($string){
        return strtr($string,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ',
        'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }
	
    public static function formatPrecio($precio,$currency = true){
        if($currency)
            return Yii::app()->numberFormatter->format('¤ ###,###,##0',$precio, "Bs");
        else
            return Yii::app()->numberFormatter->format('###,###,##0',$precio);
    }
    
	public static function isDev() // para saber cuando estemos en develop
	{
		return strpos(Yii::app()->baseUrl, "new") !== false;

	}
	
	public static function isStage() // para saber cuando estemos en staging
	{
		return strpos(Yii::app()->baseUrl, "staging") !== false;

	}

    public static function fillRow($busqueda){
    if(!is_array($busqueda))
        return "";
    
    ?>    
        <td class="title"><?php echo key($busqueda); ?></td>
            <td>
            <?php
            if(is_array(current($busqueda)))
            {
                foreach(current($busqueda) as $item)
                {
                    echo $item."<br/>";
                }
            } else{
                 echo current($busqueda);
            }
            if(next($busqueda)===false)
                return false;
            else{
                    if(strpos(key($busqueda),'*-*')){
                        echo current($busqueda).' ';
                        next($busqueda);
                    }                                                                  
                    
            } 
            
            ?>
            
            
            
            </td>
    <?php 
        return $busqueda;
    }
	
	public static function quitarGuionBajo($cadena)
	{
		
		return str_replace("_"," ",$cadena);
	}  
    
    public static function long_query($query,$field){
        $array=explode(" ",$query);
        $return="";
        foreach ($array as $key=>$item){            
            if($key<count($array)-1)
                    $return.=$field." LIKE '%".$item."%' OR ";
            
                
            else
                $return.=$field." LIKE '%".$item."%'";
                
        }
        return $return;        
        
    }
    
    public static function inCondition($string,$field){
            if(strlen($string)>0)     
                return $field." IN (".$string.")";
            else
                return "";
    }
     public static function sellerOptions(){
        return array(
            "producto"=>"Productos",
            "inventario"=>"Inventario",
            "orden"=>"Ordenes",
        );
    }

    public static function cambiarValor($cadena)
    {
        if($cadena=="on")
            return "si";
        else
            return $cadena;
        
    }

    public static function invertirFecha($fecha, $formatosinTiempo=false)
    {
        if($formatosinTiempo==true)
        {
            $invert = explode("-",$fecha); 
            $fecha_invert = $invert[2]."-".$invert[1]."-".$invert[0]; 
            return $fecha_invert; 
        }
        else
        {
            $parte1 = explode(" ",$fecha);
            $invert = explode("-",$parte1[0]); 
            $fecha_invert = $invert[2]."-".$invert[1]."-".$invert[0]; 
            return $fecha_invert." ".$parte1[1]; 
        }
    }

    public static function convertirVectoraCadena($vec)
    {
        $i=1;
        $cadena="";
        $veces=count($vec);
        foreach($vec as $vector)
        {
            if($i!=$veces)
                $cadena=$cadena.$vector.",";
            else
                 $cadena=$cadena.$vector;
            $i++;
        }
        return $cadena;
    }

    public static function getBanner($tipo, $opcion)
    {
        $model=Banner::model()->findByAttributes(array('activo'=>1, 'tipo_banner'=>$tipo));
        if($opcion==1)
            return $model->ruta;
        else
            return $model->ruta_imagen;
    }

    public static function verificarCadena($cadena)
    {
        $var=explode("(", $cadena);
        $cadena_formateada = trim($var[0]);
        $findme   = ')';
        if(array_key_exists(1, $var))
        {
            $verificar=strpos($var[1], $findme);
            if($verificar==true)
                $papa=rtrim($var[1], ")");
            else
                return false;
            return $cadena_formateada."++".$papa;
        }
        else
        {
            return false;
        }

        


    }
    
 
    
}


?>