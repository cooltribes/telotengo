<?php
$empresa_user = EmpresasHasUsers::model()->findByAttributes(array('empresas_id'=>$data->id));



echo"<tr>";
	echo '<td>'.$data->id.'</td>';
	echo '<td>'.$data->razon_social.'</td>';
	echo "<td>".$data->rif."</td>";
	echo '<td>'.$data->direccion.'</td>'; 

	echo '<td>'.Ciudad::model()->findByPk($data->ciudad)->nombre.'</td>';
	$provincia=Ciudad::model()->findByPk($data->ciudad)->provincia_id;
	echo '<td>'.Provincia::model()->findByPk($provincia)->nombre .'</td>';
	echo '<td>'.$data->telefono.'</td>';
	echo '<td>'.$data->rol.'</td>';	
	

	

		
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a>  

		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/empresas/update',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-edit"></i> Editar </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/empresas/verEmpresa',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-eye-open"></i> Ver </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/empresas/perfilVendedor',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-eye-open"></i> Ver perfil</a></li>';
			if(Documentos::model()->findByAttributes(array('empresas_id'=>$empresa_user->empresas->id)))
			{
				$documentos=Documentos::model()->findByAttributes(array('empresas_id'=>$empresa_user->empresas->id));
				$enlace=str_replace ( "/home/telotengo/public_html", "http://telotengo.com" , $documentos->rif_ruta );
				$enlace2=str_replace ( "/home/telotengo/public_html", "http://telotengo.com" , $documentos->mercantil_ruta );
				?>
				<li><a href="<?php echo $enlace;?>" class="pointer" download> <i class="glyphicon glyphicon-download"></i> Descargar RIF</a></li>
				<li><a href="<?php echo $enlace2; ?>" class="pointer" download> <i class="glyphicon glyphicon-download-alt"></i> Descargar Registro mercantil</a></li>
			<?php
			}
			else
			{
				$info=EmpresasHasUsers::model()->findBySql('select * from tbl_empresas_has_tbl_users where empresas_id="'.$data->id.'" limit 1');
				?>
				<li><a class="pointer" id=<?php echo $data->id;?>  tabindex="-1" onclick="solicitarDocumentos(<?php echo $info->users_id;?>)"><i class="glyphicon glyphicon-file"></i> Solicitar documentos </a></li>
			<?php
			}

		echo '	
		</ul>
	    </div></td>
	    
	    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    </div>		
			';
	
echo "</tr>";

?>
<script>

	function solicitarDocumentos(id)
	{
			$.ajax({
	         url: "<?php echo Yii::app()->createUrl('user/user/solicitarDocumentos') ?>",
             type: 'POST',
	         data:{
                    id:id,
                   },
	        success: function (data) {
	        	$('#emailSent').removeClass('hide');
	       	}
	       })
	}

</script>