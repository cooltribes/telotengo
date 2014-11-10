<!-- CONTENIDO ON -->
<div class="container-fluid margin_top" style="padding: 0 15px;">

<?php
$this->breadcrumbs=array(
	''.$model->nombre,
);
?>

<?php

$categorias = Categoria::model()->findAll(); 
$marcas = Marca::model()->findAll();

?>

    <div class="row"> 

        <div class="col-md-offset-1 col-md-10">
            <div class="row margin_top">
                <img src="http://placehold.it/1580x150" class="img-responsive" alt="Categoría">
            </div>
        </div>

        <!-- PRODUCTOS ON -->
        <div class="col-md-offset-1 col-md-10">
            <section class="row">

    <?php
	$template = '
		{items}
      {pager}
    ';

	$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-productos-store-marca',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_store',
	    'afterAjaxUpdate'=>" function(id, data) {	    				
						} ",
	    'template'=>$template,
	));    
	
	?>
                              
                              
            </section>
        </div>
  <!-- PRODUCTOS OFF -->

    </div>
</div>
<!-- CONTENIDO OFF -->