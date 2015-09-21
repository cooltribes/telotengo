
<table width="100%" class="detailTable margin_top">
                            <col width="15%">
                            <col width="35%"> 
                            <col width="15%">
                            <col width="35%">    
          <? unset($busqueda["_id"],$busqueda["producto"]);
          while(true): ?>
     
                    <tr>
                        <?php                            
                            $busqueda=Funciones::fillRow($busqueda);
                            if($busqueda===false)
                                break;                         
                            $busqueda=Funciones::fillRow($busqueda);
                            if($busqueda===false)
                                break;
                                
                        ?>  
                        </tr>                   
          <?php endwhile;  ?>
</table>