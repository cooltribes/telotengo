<style>
    td span{
        display:block;
        font-size: 10px;
    }
</style>
<?php      
echo"<tr>";
	$imagen = Imagenes::model()->findByAttributes(array('producto_id'=>$data->id,'orden'=>'1'));
	
	if($imagen)
	{
		 $peque=Yii::app(true)->baseUrl.'/images/producto/'.$data->id.'/'.$imagen->id."_thumb.jpg"; //OJO
		 $ruta=Yii::app(true)->baseUrl.$imagen->url;
		 echo "<td><a href='".$ruta."' target='_blank' > <img height='60' width='60' src='".$peque."' title='Haz Click encima para ver Imagen con detalle'/></a></td>";
	}
	else 
	{
		echo '<td><img src="http://placehold.it/60" align="Nombre del producto"/> </td>'; 
	}
	if($data->padre_id!=0&&$data->color_id!=0){   
    		
    	$padreCat=$data->padre->idCategoria->name(Categoria::model()->getDosPrimeras($data->padre->id_categoria));	 
    	echo "<td>".$data->nombre."<br/>".$data->modelo;
        ?>       
            <span id="ap<?php echo $data->id?>" class="<?php echo $data->aprobado?"green-text":"red-text";?>"><?php echo $data->aprobado?"Aprobado":"Rechazado";?></span>
            <span id="ac<?php echo $data->id?>" class="<?php echo $data->estado?"green-text":"red-text";?>"><?php echo $data->estado?"Activo":"Inactivo";?></span>
        <?php
    	echo "</td>";
        echo "<td>".$data->padre->nombre."<br/><small><b>".$data->padre->idMarca->nombre."</b><br/>".$padreCat." - ".$data->padre->idCategoria->nombre."<br/>"."</small></td>";
        echo "<td>".$data->creador->profile->first_name." ".$data->creador->profile->last_name."<br/><small><b>".$data->creador->empresa->razon_social."</b><br/>".$data->creador->email."<br/>".$data->created_at."</small></td>";
        echo '<td>
        <div class="dropdown">
        <a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
        <i class="icon-cog"></i> <b class="caret"></b> 
        </a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">'; ?>
                 <li><a class="pointer" id="apr<?php echo $data->id;?>" onclick="aprobar(<?php echo $data->id;?>)"><?php echo $data->aprobado?"<span class='glyphicon glyphicon-thumbs-down'></span> Rechazar":"<span class='glyphicon glyphicon-thumbs-up'></span> Aprobar";?></a></li>
                <li><a class="pointer" id="act<?php echo $data->id;?>" onclick="desactivarActivar(<?php echo $data->id;?>)"><?php echo $data->estado?"<i class='glyphicon glyphicon-remove'></i> Desactivar":"<i class='glyphicon glyphicon-ok'></i> Activar";?></a></li>
                <li><a class="pointer" href="<?php echo Yii::app()->baseUrl;?>/producto/create/<?php echo $data->id;?>"><i class="glyphicon glyphicon-cog"></i> Editar</a></li>
                 <li><a class="pointer" href="<?php echo Yii::app()->baseUrl;?>/productoPadre/update/<?php echo $data->padre->id;?>"><span class="glyphicon glyphicon-arrow-up"></span> Editar Padre</a></li>
                
     <?php  echo '  
            </ul>
            </div></td> 
                ';
    	
    echo "</tr>";
    }else{?>
        <td>
            <?php echo $data->nombre;?>
        </td>
        <td colspan="3" align="center">
           Producto cargado mediante <a class="blueLink" href="../masterdata/detalle/<?php echo $data->masterdata_id?>">Masterdata # <?php echo $data->masterdata_id;?></a>
        </td>
<?php    } 

?>

