
<?php
 echo '<tr id="'.$data->id.'">';
 $fecha_nacimiento= date("d-m-Y", strtotime($data->profile->fecha_nacimiento));
 $fecha_creado= date("d-m-Y", strtotime($data->create_at));
 	//echo '<td>'.CHtml::image($data->getAvatar(),'Avatar',array("width"=>"70", "height"=>"70")).'';
 	?>
	<td>
		<?php echo $fecha_creado;?>
	</td>
	   <td>
        <h5 class="no_margin_bottom">  <strong>Nombre</strong>:<?php echo $data->profile->first_name.' '.$data->profile->last_name; ?></h5>
        <small><strong>Cedula</strong>: <?php echo Funciones::formatPrecio($data->profile->cedula, false); ?><br/>
        	<strong>Genero</strong>: <?php echo $data->buscarSexo($data->profile->sexo); ?><br/>
        	<!-- <span class="label label-warning">Nuevo Usuario</span> -->
		</small>
      </td>
	
	    <td><small><?php echo $data->email; ?><br/>
        <strong>Telf.</strong>: <?php echo $data->profile->telefono; ?> <br/>
        <strong>Fecha de Nacimiento</strong>: <?php echo $fecha_nacimiento; ?> <br/>
        <?php
         /*if($data->status == 0){ ?>
        <strong class="text-warning text-center">Cuenta Desactivada</strong>
        <?php }else if($data->status == 1){ ?>          
        <strong class="text-error text-center">Cuenta Activa</strong>
        <?php }*/
        ?>   
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
        	<strong>Ciudad</strong>: <?php echo Ciudad::model()->findByPk($modelado->empresas->ciudad)->nombre; ?><br/>
		</small>
      </td>
      
      	<td>
        <h5 class="no_margin_bottom">  <strong>Sector</strong>:<?php echo $data->buscarSector( $modelado->empresas->sector); ?></h5>
        <!--<small><strong>Tipo</strong>: <?php echo $modelado->empresas->tipo; ?><br/> -->
        	<strong>Cargo</strong>: <?php echo $modelado->empresas->cargo; ?><br/>
		</small>
      </td>
      
	<?php
	$documentos="";


	echo '<td>
	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 

		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			';?>
			<li><a href="<?php echo Yii::app()->createUrl("user/admin/detalle", array("id"=>$data->id))?>" class="pointer" id=<?php echo $data->id;?>  tabindex="-1" ><i class="glyphicon glyphicon-eye-open"></i> Ver detalle </a></li>
			<?php
			if(Documentos::model()->findByAttributes(array('empresas_id'=>$modelado->empresas->id)))
			{
				$documentos=Documentos::model()->findByAttributes(array('empresas_id'=>$modelado->empresas->id));
				$enlace=str_replace ( "/home/telotengo/public_html", "http://telotengo.com" , $documentos->rif_ruta );
				$enlace2=str_replace ( "/home/telotengo/public_html", "http://telotengo.com" , $documentos->mercantil_ruta );
				?>
				<li><a href="<?php echo $enlace;?>" class="pointer" download> <i class="glyphicon glyphicon-download"></i> Descargar RIF</a></li>
				<li><a href="<?php echo $enlace2; ?>" class="pointer" download> <i class="glyphicon glyphicon-download-alt"></i> Descargar Registro mercantil</a></li>
			<?php
			}
			else
			{?>
				<li><a class="pointer" id=<?php echo $data->id;?>  tabindex="-1" onclick="solicitarDocumentos(<?php echo $data->id;?>)"><i class="glyphicon glyphicon-file"></i> Solicitar documentos </a></li>
			<?php
			}
			?>
				<!--<li><a class="pointer" id=<?php echo $data->id;?> tabindex="-1" onclick="desactivarActivar(<?php echo $data->id;?>)"><i class="glyphicon glyphicon-remove"></i> Desaprobar </a></li> --><?php 
			?><li><a class="pointer" id=<?php echo $data->id;?>  tabindex="-1" onclick="desactivarActivar(<?php echo $data->id;?>)"><i class="glyphicon glyphicon-ok"></i> Aprobar </a></li>
			<?php 
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
	       		$('#emailSent').html('Solicitud aprobada satisfactoriamente');
	        	$('#emailSent').removeClass('hide');
	       	}
	       })
		
	}
	function solicitarDocumentos(id)
	{
			$.ajax({
	         url: "<?php echo Yii::app()->createUrl('user/user/solicitarDocumentos') ?>",
             type: 'POST',
	         data:{
                    id:id,
                   },
	        success: function (data) {
	        	$('#emailSent').html('Correo enviado satisfactoriamente');
	        	$('#emailSent').removeClass('hide');
	       	}
	       })
	}

</script>