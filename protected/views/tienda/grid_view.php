<div class="row-fluid clearfix">
<?php 
$way=0; // 2 consultas
$quitar=0; // para quitar del inventario su mismo producto si es el mas barato
if($model2!="") //TODO ver esto
{
	$model=$model2;
	$way=1; // 3 consultas
}

$empresas=Empresas::model()->findByPk((EmpresasHasUsers::model()->findByAttributes(array('users_id'=>Yii::app()->user->id))->empresas_id)); // id del que esta intentado entrar

foreach ($model as $modelado)  //TODO esto va a mejorar la forma como se imprimen los resultados
{
	
	if($way==1)
	{
		$producto=Producto::model()->findByPk($modelado['producto_id']);
		$contador=Inventario::model()->countByAttributes(array('producto_id'=>$modelado['producto_id']));
		$almacen=Almacen::model()->findByPk($modelado['almacen_id']);
		if($empresas->id==$almacen->empresas->id)
		{
			$sql="select id, min(precio) as menoro, costo, cantidad, almacen_id, notaCondicion, garantia, producto_id, estado from tbl_inventario where producto_id='".$modelado['producto_id']."'
			 and id<>'".$modelado['id']."'";
			 $modelado = Yii::app()->db->createCommand($sql)->queryRow();
			$quitar=1;
		}
		else 
		{
			$quitar=0;
		}
		if($quitar==0 ||($quitar==1 && $modelado['id']!=""))
			$this->renderPartial('_detail', array('modelado'=>$modelado, 'way'=>$way, 'producto'=>$producto, 'contador'=>$contador, 'quitar'=>$quitar));
	}
	else 
	{
		$inventario=Inventario::model()->findByAttributes(array('producto_id'=>$modelado['id'], 'precio'=>$modelado['menor']));
		$contador=Inventario::model()->countByAttributes(array('producto_id'=>$modelado['id']));
		
		if($inventario->almacen->empresas_id==$empresas->id)
		{
			$sql="select id, min(precio) as menor, costo, cantidad, almacen_id, notaCondicion, garantia, producto_id, estado from tbl_inventario where producto_id='".$modelado['id']."' and id<>'".$inventario->id."'";
			$inventario = Yii::app()->db->createCommand($sql)->queryRow();
			$quitar=1;
		}
		else 
		{
			$quitar=0;
		}
			
		
		if(($quitar==0 && count($inventario)>0) || ($quitar==1 && $inventario['id']!=""))
		{
			$this->renderPartial('_detail', array('modelado'=>$modelado, 'way'=>$way, 'inventario'=>$inventario, 'contador'=>$contador, 'quitar'=>$quitar));
		}
			
		
	}
}
?>
</div>
    