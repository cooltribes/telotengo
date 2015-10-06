<?php
$way=0; // 2 consultas
if($model2!="") //TODO ver esto
{
	$model=$model2;
	$way=1; // 3 consultas
}
 foreach($model as $modelado)
 {
 	
	if($way==1)
	{
		$producto=Producto::model()->findByPk($modelado['producto_id']);
		$contador=Inventario::model()->countByAttributes(array('producto_id'=>$modelado['producto_id']));
		
		$this->renderPartial('_detail2', array('modelado'=>$modelado, 'way'=>$way, 'producto'=>$producto, 'contador'=>$contador));
	}
	else 
	{
		$inventario=Inventario::model()->findByAttributes(array('producto_id'=>$modelado['id']));
		$contador=Inventario::model()->countByAttributes(array('producto_id'=>$modelado['id']));
		
		if(isset($inventario))
		{
			$this->renderPartial('_detail2', array('modelado'=>$modelado, 'way'=>$way, 'inventario'=>$inventario, 'contador'=>$contador));
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