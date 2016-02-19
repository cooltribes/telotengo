<tr><td scope="col"><?php echo $data->nombre; ?></td>
<td scope="col"><?php echo $data->modelo; ?></td>
 <td scope="col">
     <?php if($data->padre_id!=0){
         echo $data->padre->nombre;
     }else{?>
         <a class="blueLink"><u>Asignar Padre</u></a>
     <?php } ?>
 </td>
<td scope="col" id="co<?php echo $data->id;?>"> <?php if($data->color_id!=0){
         echo $data->colore->nombre;
     }else{?>
         
             <?php echo CHtml::dropDownList('color'.$data->id,"0",CHtml::listData(Color::model()->findAll(),'id','nombre'), array('empty' => 'Seleccione un color')); ?> 
            
   
              <a class="blueLink pointer" onclick="set_color(<?php echo $data->id;?>)"><u><small>Guardar</small></u></a> 
          

         
         
     <?php } ?><br/><small><b>Tono: </b><?php echo $data->color ?></small></td>
<td scope="col" id="ap<?php echo $data->id;?>"><?php echo $data->aprobado?"Si":"No";?></td>
<td scope="col" id="ac<?php echo $data->id;?>"><?php echo $data->estado?"Si":"No";?></td>
<td scope="col">
    <div class="dropdown">
    <a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
    <i class="icon-cog"></i> <b class="caret"></b> </a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
             <li><a class="pointer" id="apr<?php echo $data->id;?>" onclick="aprobar(<?php echo $data->id;?>)"><?php echo $data->aprobado?"<span class='glyphicon glyphicon-thumbs-down'></span> Rechazar":"<span class='glyphicon glyphicon-thumbs-up'></span> Aprobar";?></a></li>
            <li><a class="pointer" id="act<?php echo $data->id;?>" onclick="desactivarActivar(<?php echo $data->id;?>)"><?php echo $data->estado?"<i class='glyphicon glyphicon-remove'></i> Desactivar":"<i class='glyphicon glyphicon-ok'></i> Activar";?></a></li>
            <li><a class="pointer" href="<?php echo Yii::app()->baseUrl;?>/producto/create/<?php echo $data->id;?>"><i class="glyphicon glyphicon-cog"></i> Editar</a></li>
            <?php if($data->padre_id!=0):?> 
             <li><a class="pointer" href="<?php echo Yii::app()->baseUrl;?>/productoPadre/update/<?php echo $data->padre->id;?>"><span class="glyphicon glyphicon-arrow-up"></span> Editar Padre</a></li>
            <?php endif; ?>
     </ul>
     </div>
</td>
</tr>