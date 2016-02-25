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
    
 
    
}


?>