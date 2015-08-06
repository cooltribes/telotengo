<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>
<style>
    .sadFace{
      font-size: 10em;
      font-weight: bold;
      -ms-transform: rotate(90deg);
      -webkit-transform: rotate(90deg);
      transform: rotate(90deg);
      height: 100%;
      width: 100%;
      color: #0071b9;
    }
</style>
<div class="row-fluid clearfix">
    <div class="col-md-offset-5 col-md-2 margin_top_minus">
        <div class="text-center">
        <div class="sadFace">:(</div>
</div>
        
    </div>
    
</div>
<h2 class="text-center">
   	<?php
	 if($code=="403")
	{?>
		No esta autorizado a visualizar este contenido
	<?php
	}
	else
	{?>
		Hemos tenido un problema procesando tu solicitud
	<?php	
	}?>
</h2>

<h4 class="text-center">
    Código: <?php echo $code; ?>
</h4>
