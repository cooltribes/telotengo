<?php
$caracteristicas = CaracteristicasProducto::model()->findAllByAttributes(array('producto_id'=>$data['producto_id']));
?>

<tr>
	<?php
	foreach ($caracteristicas as $cp) {
		$caracteristica_nosql = Caracteristica::model()->findByAttributes(array('caracteristica_id'=>$cp->caracteristica->id, 'inventario_id'=>$data['id']));
		?>
		<td><?php echo $cp->caracteristica->nombre; ?>: <strong><?php echo $caracteristica_nosql->valor; ?></strong></td>
		<?php
	}
	?>
    
    <td>Cantidad: <strong><?php echo $data['cantidad']; ?></strong></td>
    <td>Precio: <strong><?php echo $data['precio']; ?> Bs.</strong></td>
    <td><button type="button" class="close" aria-hidden="true" onclick="eliminar_inventario(<?php echo $data['id']; ?>)">&times;</button></td> 
</tr>