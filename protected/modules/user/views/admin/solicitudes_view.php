
<?php
 echo '<tr id="'.$data->id.'">';
 $fecha_nacimiento= date("d-m-Y", strtotime($data->profile->fecha_nacimiento));
 	//echo '<td>'.CHtml::image($data->getAvatar(),'Avatar',array("width"=>"70", "height"=>"70")).'';
 	?>
	
	   <td>
        <h5 class="no_margin_bottom">  <strong>Nombre</strong>:<?php echo $data->profile->first_name.' '.$data->profile->last_name; ?></h5>
        <small><strong>Cedula</strong>: <?php echo $data->profile->cedula; ?><br/>
        	<strong>Genero</strong>: <?php echo $data->buscarSexo($data->profile->sexo); ?><br/>
        	 <span class="label label-warning">Nuevo Usuario</span>
		</small>
      </td>
	
	    <td><small><?php echo $data->email; ?><br/>
        <strong>Telf.</strong>: <?php echo $data->profile->telefono; ?> <br/>
        <strong>Fecha de Nacimiento</strong>: <?php echo $fecha_nacimiento; ?> <br/>
        <?php if($data->status == 0){ ?>
        <strong class="text-warning text-center">Cuenta Desactivada</strong>
        <?php }else if($data->status == 1){ ?>          
        <strong class="text-error text-center">Cuenta Activa</strong>
        <?php } ?>   
     </small>

        </td>
	<?php
	
		$modelado=EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$data->id));
		echo "<td>".$modelado->empresas->rol."</td>";?>
		

	<?php
	echo "<td>";
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
	echo "<td>".$user->email."</td>";?>
				  <td>
        <h5 class="no_margin_bottom">  <strong>Empresa</strong>:<?php echo $modelado->empresas->razon_social; ?></h5>
        <small><strong>Rif</strong>: <?php echo $modelado->empresas->rif; ?><br/>
        	<strong>Direccion</strong>: <?php echo $modelado->empresas->direccion; ?><br/>
        	<strong>Ciudad</strong>: <?php echo $modelado->empresas->ciudad; ?><br/>
		</small>
      </td>
      
      	<td>
        <h5 class="no_margin_bottom">  <strong>Sector</strong>:<?php echo $data->buscarSector( $modelado->empresas->sector); ?></h5>
        <small><strong>Tipo</strong>: <?php echo $modelado->empresas->tipo; ?><br/>
        	<strong>Cargo</strong>: <?php echo $modelado->empresas->cargo; ?><br/>
		</small>
      </td>
      
	<?php


	echo '<td>
	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 

		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			';
			?>
				<!--<li><a class="pointer" id=<?php echo $data->id;?> tabindex="-1" onclick="desactivarActivar(<?php echo $data->id;?>)"><i class="glyphicon glyphicon-remove"></i> Desaprobar </a></li> --><?php 
			?><li><a class="pointer" id=<?php echo $data->id;?>  tabindex="-1" onclick="desactivarActivar(<?php echo $data->id;?>)"><i class="glyphicon glyphicon-ok"></i> Aprobar </a></li><?php 
			echo '
		</ul>
	    </div></td>
	    
	    		
			';

echo"</tr>";
	

?>


<script>

	function desactivarActivar(id)
	{
			
			$.ajax({
	         url: "<?php echo Yii::app()->createUrl('user/user/activarDesactivar') ?>",
             type: 'POST',
	         data:{
                    id:id,
                   },
	        success: function (data) {
				if(data==0)//lo contrario
				{
					$('#'+id).html('<i class="glyphicon glyphicon-ok"></i> Activar');
					//$('#'+id+'s').html('Desactivo')
					$('#'+id).hide();
				}
				else
				{
					$('#'+id).html('<i class="glyphicon glyphicon-remove"></i> Desactivar');
					//$('#'+id+'s').html('Activo')
					$('#'+id).hide();
				}
	       	}
	       })
		
	}

</script>