<?php
$way=0; // 2 consultas
$quitar=0; // para quitar del inventario su mismo producto si es el mas barato
if($model2!="") //TODO ver esto
{
	$model=$model2;
	$way=1; // 3 consultas
}
if(!Yii::app()->user->isAdmin())
	$empresas=Empresas::model()->findByPk((EmpresasHasUsers::model()->findByAttributes(array('users_id'=>Yii::app()->user->id))->empresas_id)); // id del que esta intentado entrar
 
 foreach($model as $modelado)
 {
 	
	if($way==1)
	{
		$producto=Producto::model()->findByPk($modelado['producto_id']);
		$contador=Inventario::model()->countByAttributes(array('producto_id'=>$modelado['producto_id']));
		$almacen=Almacen::model()->findByPk($modelado['almacen_id']);
		if(!Yii::app()->user->isAdmin())
		{
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
		}

		if($quitar==0 ||($quitar==1 && $modelado['id']!=""))
			$this->renderPartial('_detail2', array('modelado'=>$modelado, 'way'=>$way, 'producto'=>$producto, 'contador'=>$contador, 'quitar'=>$quitar));
	}
	else 
	{
		$inventario=Inventario::model()->findByAttributes(array('producto_id'=>$modelado['id'], 'precio'=>$modelado['menor']));
		$contador=Inventario::model()->countByAttributes(array('producto_id'=>$modelado['id']));
		
		if(!Yii::app()->user->isAdmin())
		{
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
		}

			
		
		if(($quitar==0 && count($inventario)>0) || ($quitar==1 && $inventario['id']!=""))
		{
			$this->renderPartial('_detail2', array('modelado'=>$modelado, 'way'=>$way, 'inventario'=>$inventario, 'contador'=>$contador, 'quitar'=>$quitar));
		}
			
		
	}	
 ?>
 
 

    
    
<?php 
} ?>
<!--
<div class="pager text-center margin_top">
    <a href="#"><span class="active">1</span></a>
    <a href="#"><span>2</span></a>
    <a href="#"><span>3</span></a>
    <a href="#"><span>4</span></a>
    <a href="#"><span>5</span></a>
    <a href="#"><span>6</span></a>
    <a href="#"><span>7</span></a>
    <a href="#"><span>8</span></a>
    <a href="#"><span>9</span></a>
    <a href="#"><span>10</span></a>
    <a href="#"><span>11</span></a>
    <a href="#"><span>Siguiente ></span></a>
    
</div>
-->