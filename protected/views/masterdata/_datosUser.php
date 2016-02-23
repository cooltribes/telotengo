 <tr>
            <td><?php echo $data->id;?></td>
            <td><a class="blueLink" href="<?php echo Yii::app()->getBaseUrl(true).$data->path; ?>"><u><?php echo "Masterdata".$data->id.".".pathinfo($data->path,PATHINFO_EXTENSION);?></u></a></td>
            <td><?php echo $data->user->profile->first_name." ".$data->user->profile->last_name; ?></td>
            <td><?php echo $data->user->empresa->razon_social;?></td>
            <td><?php echo date("d/m/Y - H:i:s",strtotime($data->uploaded_at)); ?></td>
 
            <td align="center"><?php echo $data->filas. " / ".count($data->productos);?></td>
            <td><a class="blueLink" href="detalleUsuario/<?php echo $data->id?>">Ver</a></td>
        </tr>
