<tr><td scope="col"><?php echo $data->nombre; ?></td>
<td scope="col"><?php echo $data->modelo; ?></td>
     <?php 
    if($data->padre_id!=0)
    {
     ?>
     <td scope="col">     
     <?php    echo $data->padre->nombre;
    }
    else
    {
        if($data->aprobado==2)
        {
            echo "<td>N/D</td>";
        }
        else
        {
        ?>
         <td scope="col" align="center" id="pa<?php echo $data->id;?>">
         <?php      $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                        'id'=>'padre'.$data->id,
                                        'name'=>'padre'.$data->id,
                                        'source'=>$this->createUrl('ProductoPadre/autocomplete'),
                                        'htmlOptions'=>array(
                                              'size'=>30,
                                              'placeholder'=>'Introduzca nombre del producto',
                                              'class'=>'padding_left_small padding_right_small'
                                              
                                              //'maxlength'=>45,
                                            ),
                                        // additional javascript options for the autocomplete plugin
                                        'options'=>array(
                                                'showAnim'=>'fold',
                                        ),
                                        ));
                       
                                        ?><br/>
            <div class="padreOptions">
                <div> <a class="blueLink pointer" onclick="set_padre(<?php echo $data->id;?>)"><small><u>Asignar Padre</u></small></a></div>
                <div><div class="padreCreate" style="display:none;" id="crear_padre<?php echo $data->id?>">Padre no existe 
                    <a href="<?php echo Yii::app()->createUrl("Producto/clasificar",array("son"=>$data->id));?>">Crear</a></div> </div>
            </div>
        <?php 
        }
    } ?>
 </td>
<td scope="col" id="co<?php echo $data->id;?>"> <?php if($data->color_id!=0){
         echo $data->colore->nombre;
     }else{?>
         
             <?php echo CHtml::dropDownList('color'.$data->id,"0",CHtml::listData(Color::model()->findAll(),'id','nombre'), array('empty' => 'Seleccione un color')); ?> 
            
   
              <a class="blueLink pointer" onclick="set_color(<?php echo $data->id;?>)"><u><small>Guardar</small></u></a> 
          

         
         
     <?php } ?><br/><small><b>Tono: </b><?php echo $data->color ?></small></td>
<td scope="col" id="ap<?php echo $data->id;?>"><?php if($data->aprobado==0)echo "Pendiente"; if($data->aprobado==1)echo "Aprobado"; if($data->aprobado==2)echo "Rechazado" ?></td>
<td scope="col" id="ac<?php echo $data->id;?>"><?php echo $data->estado?"Si":"No";?></td>
<td scope="col">
    <?php
    if($data->aprobado!=2)
    { ?>
    <div class="dropdown">
    <a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
    <i class="icon-cog"></i> <b class="caret"></b> </a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
        <?php
            if($data->aprobado==0): ?>
                <li><a class="pointer"  onclick="rechazar(<?php echo $data->id;?>)"><i class='glyphicon glyphicon-remove'></i> Rechazar</a></li>
            <?php endif;    
             /* <li><a class="pointer" id="apr<?php echo $data->id;?>" onclick="aprobar(<?php echo $data->id;?>)"><?php echo $data->aprobado?"<span class='glyphicon glyphicon-thumbs-down'></span> Rechazar":"<span class='glyphicon glyphicon-thumbs-up'></span> Aprobar";?></a></li> 
           /* <li><a class="pointer" id="act<?php echo $data->id;?>" onclick="desactivarActivar(<?php echo $data->id;?>)"><?php echo $data->estado?"<i class='glyphicon glyphicon-remove'></i> Desactivar":"<i class='glyphicon glyphicon-ok'></i> Activar";?></a></li>*/ ?>
            <?php if($data->padre_id!=0):?> 
            <li><a class="pointer" href="<?php echo Yii::app()->baseUrl;?>/producto/modificarProducto/<?php echo $data->id;?>"><i class="glyphicon glyphicon-cog"></i> Verificar</a></li>
             <li><a class="pointer" href="<?php echo Yii::app()->baseUrl;?>/productoPadre/update/<?php echo $data->padre->id;?>"><span class="glyphicon glyphicon-arrow-up"></span> Editar Padre</a></li>
            <?php endif; 
    }
    else
    {?>
        

        <a data-toggle="tooltip"  title="No puede realizar acciones ya que el producto esta rechazado, diríjase al administrador de variaciones" onclick="alerta()" class="dropdown-toggle btn" id="dLabel" role="button" data-target="#" href="#">
        <i class="icon-cog"></i> <b class="caret"></b> </a> 
    <?php
    }?>
     </ul>
     </div>
</td>
</tr>