<?php

$ima ='';

echo"<tr>";
   	
	echo "<td>".$data->id."</td>";

    if(User::model()->findByPk(Yii::app()->user->id)->isAdmin()) 
       echo "<td>".Empresas::model()->findByPk((EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$data->user->id))->empresas_id))->razon_social."</td>"; 
    else
       echo "<td>".Funciones::invertirFecha($data->fecha_carga)."</td>"; 
        
	echo "<td>".$data->user->profile->first_name." ".$data->user->profile->last_name."</td>";
    
    if(User::model()->findByPk(Yii::app()->user->id)->isAdmin()) 
    {
        echo "<td>".Funciones::invertirFecha($data->fecha_carga)."</td>";
        echo "<td>".$data->total_productos."</td>";
         echo "<td>".$data->total_cantidad."</td>";   
    }   
    else
    {
       echo "<td>".$data->total_productos."</td>";
       echo "<td>".$data->total_cantidad."</td>"; 
    }


	
  
	
	
	
	


?>
<td>
        <div class="dropdown"> 
            <a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="">
                <i class="icon-cog"></i> <b class='caret'></b>
            </a> 
            <!-- Link or button to toggle dropdown -->
            <ul class="dropdown-menu pull-right text_align_left" role="menu" aria-labelledby="dLabel">
                
                <li>
                    <?php echo CHtml::link('<i class="icon-list-alt"></i>  Descargar Excel',
                            $this->createUrl("/inbound/descargarExcel", array("id"=>$data->id))
                    ); ?>                                
                </li>                  
            </ul>
        </div>

</td>

<?php	
echo"</tr>";

// esto se comento porque no queremos borrar los almacenes
// <li><a tabindex="-1" href="'.Yii::app()->createUrl('/almacen/delete',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-trash"></i> Desactivar </a></li>
?>