<?php
$model=Producto::model()->findByPk($data->producto_id);
$ima ='';

echo"<tr>";
   	
	echo "<td>".$model->tlt_codigo."</td>";
   	echo "<td>".$model->nombre."</td>";
	echo "<td>".$data->cantidad."</td>";
	echo "<td>".$this->retornarProducto($data->producto_id)."</td>";

	
echo"</tr>";
?>