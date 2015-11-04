<!--<tr>
    <td><input type="checkbox"/></td>
    <td>1</td>
    <td>2</td>
    <td>3</td>
    <td>4</td>
    <td>5</td>
    <td>6</td>
    <td>7</td>
    <td>8</td>
    <td><span class="glyphicon glyphicon-cog"></span></td>
</tr>-->


<?php
echo "<tr>";
    echo '<td><input type="checkbox"/></td>';   
    echo '<td><img width:"60px" src="http://placehold.it/60x60"/></td>';   
    echo "<td><b>".$data->profile->first_name.' '.$data->profile->last_name."</b><br/><b>ID:</b>".$data->id."</td>"; 
    echo "<td>".$data->email."<br/><b>Telf:</b>".$data->profile->telefono."</td>";
    
    if($data->superuser==1)
    {
        echo "<td colspan='2'>Administrador del Sistema</td>";
    }
    else 
    {
        $modelado=EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$data->id));
        if($modelado):
         echo "<td>".$modelado->empresas->razon_social."</td>";
         echo "<td>".$modelado->empresas->rol."</td>";
        else:
          echo "<td>N/D</td><td>N/D</td>";  
        endif;
       
    }
    
    
   /*  echo "<td>";
        switch ($data->type) {
            case User::TYPE_INVITADO_EMPRESA:
                echo 'Invitado como empresa';
                break;
            case User::TYPE_INVITADO_CLIENTE:
                echo 'Invitado como cliente';
                break;
            case User::TYPE_USUARIO_SOLICITA:
                echo 'Usuario realizó solicitud';
                break;
        }
    echo "</td>";
    $user = User::model()->findByPk($data->quien_invita);

   echo "<td>";
        switch ($data->status) {
            case User::STATUS_NOACTIVE:
                echo 'Inactivo';
                break;
            case User::STATUS_ACTIVE:
                echo 'Activo';
                break;
            case User::STATUS_BANNED:
                echo 'Suspendido';
                break;
            default:
                echo 'Desconocido';
                break;
        }
    echo "</td>";*/
    echo "<td>".$data->ingresos."</td>"; 
   
    $fecha= date("d-m-Y", strtotime($data->lastvisit_at));
    echo "<td>".$fecha."</td>"; 
    if($data->status==1)
    {
        echo "<td> <div id='".$data->id."s"."'> Activo </div></td>";
    }
    else 
    {
        echo "<td> <div id='".$data->id."s"."'> Inactivo </div></td>";
    }

    if($data->superuser!=1)
    {   
    echo '<td>

    <div class="dropdown">
    <a class="dropdown-toggle btn no_horizontal_padding" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
   <i class="glyphicon glyphicon-cog"></i>
    </a> 

        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li><a tabindex="-1" href="'.Yii::app()->createUrl('/user/profile/profile',array('id'=>$data->id)).'">Ver Usuario </a></li>
            <li><a tabindex="-1" href="'.Yii::app()->createUrl('/user/admin/create',array('id'=>$data->id)).'">Editar </a></li>';
            /*if($data->status==1){?>
                <li><a class="pointer" id=<?php echo $data->id;?> tabindex="-1" onclick="desactivarActivar(<?php echo $data->id;?>)"><i class="glyphicon glyphicon-remove"></i> Desactivar </a></li><?php }
            else{?><li><a class="pointer" id=<?php echo $data->id;?>  tabindex="-1" onclick="desactivarActivar(<?php echo $data->id;?>)"><i class="glyphicon glyphicon-ok"></i> Activar </a></li><?php } 
            */echo '
        </ul>
        </div></td>
        
                
            ';
     }
    else
        echo "<td></td>";
echo"</tr>";
    

?>
