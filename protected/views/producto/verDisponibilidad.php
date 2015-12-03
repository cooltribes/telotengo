<h1><?php echo $nombre;?></h1>
<div class="col-md-4 no_left_padding margin_top"><?php
$imagen = Imagenes::model()->findByAttributes(array('producto_id'=>$id,'orden'=>'1'));
	
	if($imagen)
	{
		 $peque=Yii::app(true)->baseUrl.'/images/producto/'.$id.'/'.$imagen->id."_thumb.jpg"; //OJO
		 $ruta=Yii::app(true)->baseUrl.$imagen->url;
		 echo "<td><a href='".$ruta."' target='_blank' > <img height='300' width='300' src='".$peque."' title='Haz Click encima para ver Imagen con detalle'/></a></td>";
	}
	else 
	{
		echo '<td><img src="http://placehold.it/60" align="Nombre del producto"/> </td>';
	}
	
	foreach($model as $data)
	{
?></div>

<div class="col-md-8 no_right_padding margin_top">
<?php		
		echo '<table class="table table-striped no_margin_bottom pointer"  width="100%"><col width="90%"/><col width="10%"/>';
            	
			
			echo '<thead class="tablas" id="'.$data['id'].'" ><tr>';
			echo '<th><a id="ic-'.$data['id'].'" class="tablas glyphicon glyphicon-plus white"></a>'	;
			echo " <strong>".$data['razon_social']."</strong></th>";
			echo "<th> <u><strong>".$data['total']."</strong></u></th>";
			$sql="select  e.id , a.alias, i.cantidad as total from tbl_empresas e JOIN tbl_almacen a on e.id=a.empresas_id JOIN tbl_inventario i on a.id=i.almacen_id where i.producto_id='".$id."' and e.id='".$data['id']."' ";
			$info=Yii::app()->db->createCommand($sql)->queryAll();
			echo '<table class="table table-striped" id="'.$data['id'].'2" width="100%" style="display:none"><col width="90%"/><col width="10%"/>';	
				foreach($info as $modelado)
				{
					echo "<tr>";	
					echo "<td class='padding_left_large'>".$modelado['alias']."</td>";	
					echo "<td>".$modelado['total']."</td>";
					echo "</tr>";
				}
			echo '</table>';
			echo "</tr></thead>";
			
		echo '</table>';
	}
	
?>
</div>
<script>
	
	$(document).ready(function (){
		
		$('.tablas').on('click', function(event) {
			 var id=$(this).attr('id');
			 if ( $( '#'+id ).hasClass( "quitar" ) ) 
			 { 
			 	 $('#'+id+'2').hide();
			 	 $('#ic-'+id).removeClass("glyphicon-minus");
			 	 $('#ic-'+id).addClass("glyphicon-plus");
				 $( '#'+id ).removeClass( "quitar" );
			 }
			 else
			 {
			 	  $('#'+id+'2').show();
			 	  $('#ic-'+id).removeClass("glyphicon-plus");
			 	  $('#ic-'+id).addClass("glyphicon-minus");
			 	  $( '#'+id ).addClass( "quitar" );
			 }
			
		});	
		
	});
</script>