<!-- CONTENIDO ON -->

    <?php
        $this->breadcrumbs=array(
            'Productos'=>array("producto/admin"),
            'Nuevos productos de usuarios'
        );
    ?>

        <h1>Productos creados por usuarios</h1>
        <hr/>
    
        <div class="col-md-12">

            <?php if(Yii::app()->user->hasFlash('success')){?>
                <div class="alert in alert-block fade alert-success text_align_center">
                    <?php echo Yii::app()->user->getFlash('success'); ?>
                </div>
            <?php } ?>
            <?php if(Yii::app()->user->hasFlash('error')){?>
                <div class="alert in alert-block fade alert-danger text_align_center">
                    <?php echo Yii::app()->user->getFlash('error'); ?>
                </div>
            <?php } ?>
         </div>
        <form class="margin_bottom margin_top form-search no_horizontal_padding row-fluid clearfix">
                         <div class="col-md-3 no_horizontal_padding">
                             <input class="form-control no_radius" id="query" name="query" type="text" placeholder="Nombre del Producto">                   
                         </div>
                         <div class="col-md-1 no_padding_left">
                             <a href="#" class="btn form-control btn-darkgray white" id="btn_search_event">Buscar</a>
                         </div>
                         <div class="col-md-offset-8"></div>
                                
        </form>



        <div class="row-fluid margin_top">
                      

        <?php
        Yii::app()->clientScript->registerScript('query1',
            "var ajaxUpdateTimeout;
            var ajaxRequest;
            $('#btn_search_event').click(function(){
                ajaxRequest = $('#query').serialize();
                clearTimeout(ajaxUpdateTimeout);
                
                ajaxUpdateTimeout = setTimeout(function () {
                    $.fn.yiiListView.update(
                    'list-auth-categorias',
                    {
                    type: 'POST',   
                    url: '" . CController::createUrl('producto/revisionNuevos') . "',
                    data: ajaxRequest}
                    )
                    },
            300);
            return false;
            });",CClientScript::POS_READY
        );
        
        // Codigo para actualizar el list view cuando presionen ENTER
        
        Yii::app()->clientScript->registerScript('query',
            "var ajaxUpdateTimeout;
            var ajaxRequest; 
            
            $(document).keypress(function(e) {
                if(e.which == 13) {
                    ajaxRequest = $('#query').serialize();
                    clearTimeout(ajaxUpdateTimeout);
                    
                    ajaxUpdateTimeout = setTimeout(function () {
                        $.fn.yiiListView.update(
                        'list-auth-categorias',
                        {
                        type: 'POST',   
                        url: '" . CController::createUrl('producto/revisionNuevos') . "',
                        data: ajaxRequest}
                        
                        )
                        },
                
                300);
                return false;
                }
            });",CClientScript::POS_READY
        );  
        ?>
        
         
            
    

        
        <?php
        $template = '{summary}
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
         <thead>   <tr>
                 <th scope="col">Imagen</th>
                <th scope="col">Producto</th>
                <th scope="col">Producto Padre</th>
                <th scope="col">Creación</th>
                <th scope="col">Acciones</th>
            </tr>
          </thead>
        {items}
        </table>
        {pager} 
        ';

            $this->widget('zii.widgets.CListView', array(
            'id'=>'list-auth-categorias',
            'dataProvider'=>$dataProvider,
            'itemView'=>'_nuevos',
            'template'=>$template,
            'enableSorting'=>'true',
             'summaryCssClass'=>'pull-left',
            'afterAjaxUpdate'=>" function(id, data) {
                               
                                } ", 
            'pager'=>array(
                'header'=>'',
                'htmlOptions'=>array(
                'class'=>'pagination pagination-right',
            )
            ),                  
        ));  
        
        ?>
        </div>

   <script>

    function desactivarActivar(id)
    {
            
            $.ajax({
             url: "<?php echo Yii::app()->createUrl('producto/activarDesactivar') ?>",
             type: 'POST',
             data:{
                    id:id,
                   },
            success: function (data) {
                if(data==0)//lo contrario
                {
                    $('#act'+id).html('<i class="glyphicon glyphicon-ok"></i> Activar');
                    $('#ac'+id).html('Inactivo');
                    $('#ac'+id).removeClass();
                    $('#ac'+id).addClass("red-text");
                }
                else
                {
                    $('#act'+id).html('<i class="glyphicon glyphicon-remove"></i> Desactivar');
                    $('#ac'+id).html('Activo');
                    $('#ac'+id).removeClass();
                    $('#ac'+id).addClass("green-text");
                }
            }
           })
        
    }
    
    function aprobar(id)
    {
            
            $.ajax({
             url: "<?php echo Yii::app()->createUrl('producto/aprobarNuevo') ?>",
             type: 'POST',
             data:{
                    id:id,
                   },
            success: function (data) {
                if(data==0)//lo contrario
                {
                    $('#apr'+id).html("<span class='glyphicon glyphicon-thumbs-up'></span> Aprobar");
                    $('#ap'+id).html('Rechazado');
                    $('#ap'+id).removeClass();
                    $('#ap'+id).addClass("red-text");
                }
                else
                {
                    $('#apr'+id).html("<span class='glyphicon glyphicon-thumbs-down'></span> Rechazar");
                    $('#ap'+id).html('Aprobado');
                    $('#ap'+id).removeClass();
                    $('#ap'+id).addClass("green-text");
                }
            }
           });
       }
     function rechazar(id)
    {
            
            $.ajax({
             url: "<?php echo Yii::app()->createUrl('producto/rechazarProducto') ?>",
             type: 'POST',
             data:{
                    id:id,
                   },
            success: function (data) {
                    $('#'+id).hide();
            }
           });
       }

        
    
    function desactivarActivarDestacado(id)
    {
            
            $.ajax({
             url: "<?php echo Yii::app()->createUrl('producto/activarDesactivarDestacado') ?>",
             type: 'POST',
             data:{
                    id:id,
                   },
            success: function (data) {
                
                if(data==0)
                {
                    $('#des'+id).html('<i class="glyphicon glyphicon-ok"></i> Destacar');
                    $('#pal'+id).html('No Destacado');
                }
                else
                {
                    $('#des'+id).html('<i class="glyphicon glyphicon-ok"></i> Quitar Destacado');
                    $('#pal'+id).html('Destacado');
                }
            }
            
            
           })
        
    }

</script>
