<?php
/* @var $this FlashsaleController */
/* @var $model Flashsale */
$this->breadcrumbs=array(
    'Administrar',
);
?>



     
     
     <div class="row-fluid clearfix">
               <div class="col-md-8">
                     <h1 class="orderTitle">Administrador de Invitaciones</h1>
               </div>
          
               <div class="col-md-3 col-md-offset-1 no_padding_right">
                     <?php
         echo CHtml::link('Invitar usuario', $this->createUrl('invitarUsuario'), array('class'=>'btn form-control btn-orange orange_border white', 'role'=>'button'));
                ?>
               </div>
           </div>

    
    <hr class="no_margin_top"/>

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
        <div>
            
         <div class="row-fluid clearfix stats">
             <div class="col-md-1 stat">
                 <span class="value"><?php echo User::model()->countInvited(2)+User::model()->countInvited(3);?></span>
                 <span class="legend">Totales</span>
             </div>
             <div class="col-md-2 stat">
                 <span class="value"><?php echo User::model()->countInvited(2);?></span>
                 <span class="legend">Cómo nueva empresa</span>
             </div>
             <div class="col-md-2 stat">
                 <span class="value"><?php echo User::model()->countInvited(3);?></span>
                 <span class="legend">Cómo miembro de empresa</span>
             </div>
      <!--       <div class="col-md-2 stat">
                 <span class="value"><?php echo User::model()->countInvited(4);?></span>
                 <span class="legend">Por solicitud de membresía</span>
         </div>-->
             <!--
             <div class="col-md-1 stat">
                 <span class="value">8888</span>
                 <span class="legend">Pago confirmado</span>
             </div>
             <div class="col-md-1 stat">
                 <span class="value">8888</span>
                 <span class="legend">Pago insuficiente</span>
             </div>
             <div class="col-md-1 stat">
                 <span class="value">8888</span>
                 <span class="legend">Enviados</span>
             </div>
             <div class="col-md-1 stat">
                 <span class="value">8888</span>
                 <span class="legend">Recibidos</span>
             </div>
             <div class="col-md-1 stat">
                 <span class="value">8888</span>
                 <span class="legend">Devueltos</span>
             </div>
             -->
         </div>   
         <hr/>  
                     <div class="margin_top col-md-12 no_horizontal_padding">

             <form class="margin_bottom form-search row-fluid">
                 <div class="col-md-3 col-md-offset-8 no_padding_right">
                    <input class="form-control no_radius_right" id="query" name="query" type="text" placeholder="Nombre o email">              
                 </div>
                 <div class="col-md-1 no_padding_left">
                     <a href="#" class="btn form-control btn-darkgray white" id="btn_search_event">Buscar</a>
                 </div>   
             </form>
            </div>   

       </div>
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
                    url: '" . CController::createUrl('admin/adminInvite') . "',
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
                        url: '" . CController::createUrl('admin/adminInvite') . "',
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
        Yii::app()->clientScript->registerScript('query1',
            "var ajaxUpdateTimeout;
            var ajaxRequest;
            $('#btn_search_event').click(function(){
                ajaxRequest = $('#query').serialize();
                clearTimeout(ajaxUpdateTimeout);
                
                ajaxUpdateTimeout = setTimeout(function () {
                    $.fn.yiiListView.update(
                    'list-auth-invitaciones',
                    {
                    type: 'POST',   
                    url: '" . CController::createUrl('admin/adminInvite') . "',
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
                        'list-auth-invitaciones',
                        {
                        type: 'POST',   
                        url: '" . CController::createUrl('admin/adminInvite') . "',
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
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-hover table-striped margin_top">
          <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre y Apellido</th>
                <th scope="col">E-mail</th>
                <th scope="col">Empresa</th>
                <th scope="col">Invitado por</th>
            </tr>
           </thead>
        {items}
        </table>
        {pager} 
        ';

            $this->widget('zii.widgets.CListView', array(
            'id'=>'list-auth-invitaciones',
            'dataProvider'=>$dataProvider,
            'itemView'=>'_datos',
            'template'=>$template,
            'summaryCssClass'=>'pull-left',
            'enableSorting'=>'true',
            'pager'=>array(
                'header'=>'',
                'htmlOptions'=>array(
                'class'=>'pagination pagination-right',
            )
            ),                  
        ));  
        
        ?>

    <div id="productosOrden" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>    

</div>


