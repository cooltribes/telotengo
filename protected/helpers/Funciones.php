<?php
class Funciones {
    
    public static function cleanUrlSeo($string){
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
       $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.    
       return strtolower(preg_replace('/-+/', '-', $string));
    }    
     
    public static function stripAccents($string){
        return strtr($string,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ',
        'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }
	
	public static function isDev() // para saber cuando estemos en develop
	{
		return strpos(Yii::app()->baseUrl, "new") !== false;

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
    
 
    
}


?>