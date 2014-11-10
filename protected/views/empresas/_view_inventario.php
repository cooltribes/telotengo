<?php
$almacen = Almacen::model()->findByPk($data['almacen_id']);
$producto = Producto::model()->findByPk($data['producto_id']);

$caracteristicas = Caracteristica::model()->findAllByAttributes(array('inventario_id'=>$data['id'], 'producto_id'=>$producto->id));
$caracteristicas_texto = '';
$cont = 1;

if(sizeof($caracteristicas) > 0){
	foreach ($caracteristicas as $c) {
		if($cont == sizeof($caracteristicas)){
			$caracteristicas_texto .= $c->valor;
		}else{
			$caracteristicas_texto .= $c->valor.', ';
		}
		$cont++;
	}
}
echo"<tr>";
	echo '<td>'.$data['id'].'</td>';
	echo "<td>".$almacen->alias."</td>";
	echo '<td>'.$producto->nombre.'<br/><small>'.$caracteristicas_texto.'</small></td>';
	echo '<td>'.$data['cantidad'].'</td>';
	echo '<td>'.Yii::app()->numberFormatter->formatCurrency($data['precio'], '').' Bs.</td>';
	?>

	<td>
		<div class="dropdown">
			<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
				<i class="icon-cog"></i> <b class="caret"></b>
			</a> 

			<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				<li><a tabindex="-1" href="<?php echo Yii::app()->createUrl('/inventario/eliminarAdmin',array('id'=>$data['id'])); ?>" ><i class="glyphicon glyphicon-trash"></i> Eliminar </a></li>
			</ul>
		</div>
	</td>
	<?php
echo "</tr>";
?>