<!-- CONTENIDO ON -->
<div class="container">

<?php
$this->breadcrumbs=array(
    ''.$model->nombre,
);
?>

<?php

$categorias = Categoria::model()->findAll(); 
$marcas = Marca::model()->findAll();

?> 

    <div class="row-fluid"> 
    <h1><?php echo $model->nombre;?> <small>en Sigmatiendas</small></h1> <hr class="no_margin_top"/>
        
        <!-- PRODUCTOS ON -->
        <div class="col-md-12">
            <section>

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