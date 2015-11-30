<?php 
echo $nombre;
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
		
		echo '<table class="table table-striped">';	
			
			echo "<tr>";
			echo '<td><a id="'.$data['id'].'" class="tablas glyphicon glyphicon-minus quitar"></a>'	;
			echo " <u><strong>".$data['razon_social']."</strong></u></td>";
			echo "<td> <u><strong>".$data['total']."</strong></u></td>";
			$sql="select  e.id , a.alias, i.cantidad as total from tbl_empresas e JOIN tbl_almacen a on e.id=a.empresas_id JOIN tbl_inventario i on a.id=i.almacen_id where i.producto_id='".$id."' and e.id='".$data['id']."' ";
			$info=Yii::app()->db->createCommand($sql)->queryAll();
			echo '<table class="table table-striped" id="'.$data['id'].'2">';	
				foreach($info as $modelado)
				{
					echo "<tr>";	
					echo "<td>".$modelado['alias']."</td>";	
					echo "<td>".$modelado['total']."</td>";
					echo "</tr>";
				}
			echo '</table>';
			echo "</tr>";
			
		echo '</table>';
	}
	
?>

<script>
	
	$(document).ready(function (){
		
		$('.tablas').on('click', function(event) {
			 var id=$(this).attr('id');
			 if ( $( '#'+id ).hasClass( "quitar" ) ) 
			 { 
			 	 $('#'+id+'2').hide();
			 	 $('#'+id).removeClass("glyphicon-minus");
			 	 $('#'+id).addClass("glyphicon-plus");
				 $( '#'+id ).removeClass( "quitar" );
			 }
			 else
			 {
			 	  $('#'+id+'2').show();
			 	  $('#'+id).removeClass("glyphicon-plus");
			 	  $('#'+id).addClass("glyphicon-minus");
			 	  $( '#'+id ).addClass( "quitar" );
			 }
			
		});	
		
	});
</script>