<div class="row-fluid clearfix">
<?php 
$way=0; // 2 consultas
if($model2!="") //TODO ver esto
{
	$model=$model2;
	$way=1; // 3 consultas
}
foreach ($model as $modelado)  //TODO esto va a mejorar la forma como se imprimen los resultados
{
	
	if($way==1)
	{
		$producto=Producto::model()->findByPk($modelado['producto_id']);
		$contador=Inventario::model()->countByAttributes(array('producto_id'=>$modelado['producto_id']));
		
		$this->renderPartial('_detail', array('modelado'=>$modelado, 'way'=>$way, 'producto'=>$producto, 'contador'=>$contador));
	}
	else 
	{
		$inventario=Inventario::model()->findByAttributes(array('producto_id'=>$modelado['id']));
		$contador=Inventario::model()->countByAttributes(array('producto_id'=>$modelado['id']));
		
		if(isset($inventario))
		{
			$this->renderPartial('_detail', array('modelado'=>$modelado, 'way'=>$way, 'inventario'=>$inventario, 'contador'=>$contador));
		}
			
		
	}
}
?>
</div>
    