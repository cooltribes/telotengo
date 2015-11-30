
<table width="100%" class="detailTable margin_top table-bordered">
                            <col width="15%">
                            <col width="35%"> 
                            <col width="15%">
                            <col width="35%">    
         <? unset($busqueda["_id"],$busqueda["producto"]);
          while(true): ?>
     
    <tr>
        <?php if(!is_array($busqueda)) break;?>    
        <td class="title"><?php echo Funciones::quitarGuionBajo(key($busqueda)); ?></td>
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
                break;
            else{
                    if(strpos(key($busqueda),'*-*')){
                        echo current($busqueda).' ';
                        next($busqueda);
                    }                                                                  
                    
            } ?>
        </td>
                        
        <?php if(!isset($solo_una)): ?>               
        <?php if(current($busqueda)===false) break;?>    
        <td class="title"><?php echo Funciones::quitarGuionBajo(key($busqueda)); ?></td>
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
                break;
            else{
                    if(strpos(key($busqueda),'*-*')){
                        echo current($busqueda).' ';
                        next($busqueda);
                    }                                                                  
                    
            } ?>
        </td>
        <?php endif; ?>
                        
        <?php if(current($busqueda)===false) break; ?>        
            
    </tr>                   
          <?php endwhile;  ?>
</table>