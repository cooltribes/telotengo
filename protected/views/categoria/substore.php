
<script>

    $('#catTitle h1').html('<?php echo $categoria; ?>');
    $('#catTitle').removeClass('hide');
</script>
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