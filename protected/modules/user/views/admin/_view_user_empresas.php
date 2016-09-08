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
	echo "<td>";
	 if($data->avatar_url){
         echo CHtml::image(str_replace(".", "_thumb.", Yii::app()->baseUrl.$data->avatar_url),"Avatar",array('width'=>'60 px','style'=>'border-radius: 0px;'));
      }else{
         echo '<img src="http://placehold.it/60x60" class="img-responsive" alt="Responsive image">';
     }
	 echo "</td>";   
    #echo '<td><img width:"60px" src="http://placehold.it/60x60"/></td>';   
    echo "<td><b>".$data->profile->first_name.' '.$data->profile->last_name."</b><br/></td>"; 
    echo "<td>".$data->email."<br/><b>Telf:</b>".$data->profile->telefono."</td>";
    
   $modelado=EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$data->id));
        if($modelado):
         echo "<td>".$modelado->rol."</td>";
        else:
          echo "<td>N/D</td>";  
        endif;

    if($modelado->admin==1)
        $cargo="Administrador";
    else
        $cargo="Manager";
    echo "<td id=cargo".$data->id.">".$cargo."</td>";

    echo '<td>

    <div class="dropdown">
    <a class="dropdown-toggle btn no_horizontal_padding" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
   <i class="glyphicon glyphicon-cog"></i>
    </a> 

        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li><a tabindex="-1" href="'.Yii::app()->createUrl('/user/profile/index',array('ide'=>$data->id)).'"><i class="glyphicon glyphicon-eye-open"></i> Ver Perfil </a></li>
            ';
            if($modelado->admin==0)
            {?>
                <li><a class="pointer" id=<?php echo $data->id;?>  tabindex="-1" onclick="activarAdministrador(<?php echo $data->id;?>)"><i class="glyphicon glyphicon-ok"></i> Hacer administrador </a></li>

                <?php
            }
        echo '
        </ul>
        </div></td>
        
                
            ';

        #echo "<td></td>";
echo"</tr>";
    

?>

<script>

    function activarAdministrador(id)
    {
            
            $.ajax({
             url: "<?php echo Yii::app()->createUrl('user/user/activarAdministrador') ?>",
             type: 'POST',
             data:{
                    id:id,
                   },
            success: function (data) {
                $('#'+id).hide();
                $('#cargo'+id).text('Administrador');
            }
           })
        
    }

</script>
