<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle='Producto - Error';
$this->breadcrumbs=array(
    'Productos'=>array('producto/seleccion'),
    'Error',
);
?>
<style>
    .sadFace{
      font-size: 10em;
      font-weight: bold;
      height: 100%;
      width: 100%;
      color: #0071b9;
    }
</style>
<div class="row-fluid clearfix">
    <div class="col-md-offset-5 col-md-2 margin_top">
        <div class="text-center">
        <div class="sadFace"><span class="glyphicon glyphicon-ban-circle"></span></div>
</div>
        
    </div>
    
</div>
<h2 class="text-center">
    Este producto requiere estar activo y aprobado para agregarle inventario
    
</h2>


<h4 class="text-center margin_top_large">
    <a class="blueLink" href="<?php echo $this->createUrl("producto/seleccion");?>">Volver a productos</a>
</h4>
