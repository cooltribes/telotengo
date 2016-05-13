<style>
    #resumen thead tr th{
        font-weight:bold;
        background: transparent;
        text-decoration:underline;
        color:#222;
        padding: 5px;               
    }
    #resumen thead tr td{        
        padding: 5px;               
    }
    .padreOptions{
        width:100%;
        float:left;        
    }
    .padreOptions>div{
        width:50%;
        float:left;
        text-align:left;
    }
    .padreOptions>div>.padreCreate{
        text-align: right;
        width: 100%;
        font-size: 12px;
        color: crimson;
        padding-right:4px;
    }
    .padreOptions>div>.padreCreate>a{
        color:#428bca;
        text-decoration: underline;
    }
    .ui-autocomplete-input{
        width:90%;
    }
    
</style>
<?php
    $this->breadcrumbs=array(
    'Masterdata' => array('masterdata/admin'),
     'detalle',
);
?>


<h1>Detalle de Masterdata #<?php echo $model->id;?></h1>
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
<table id="resumen" class="margin_top" width="100%;">
    <thead>
        <tr>
            <th>Archivo</th>
            <th>Subido por</th>
            <th>Empresa</th>
            <th>Fecha - Hora</th>
            <th align="center" >Errores</th>
            <th align="center">Productos Importados</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><a class="blueLink" href="<?php echo Yii::app()->getBaseUrl(true).$model->path; ?>"><u><?php echo "Masterdata".$model->id.".".pathinfo($model->path,PATHINFO_EXTENSION);?></u></a></td>
            <td><?php echo $model->user->profile->first_name." ".$model->user->profile->last_name; ?></td>
            <td><?php echo $model->user->empresa->razon_social;?></td>
            <td><?php echo date("d/m/Y - H:i:s",strtotime($model->uploaded_at)); ?></td>
            <td align="center"><?php echo $model->errors; ?></td>   
            <td align="center"><?php echo count($model->productos);?></td>
        </tr>
    </tbody>
</table>
<div>
<?php
        $template = '{summary}
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
         <col width="35%">
         <col width="15%">
         <col width="30%">
         <col width="15%">
         <col width="10%">
         <col width="10%">
         <col width="5%">
         <thead>   <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Modelo</th>
                <th scope="col">Padre</th>
                <th scope="col">Color</th>
                <th scope="col">Estatus</th>
                <th scope="col">Activo</th>
                <th scope="col">Acciones</th>
            </tr>
          </thead>
        {items}
        </table>
        {pager} 
        ';

            $this->widget('zii.widgets.CListView', array(
            'id'=>'list-auth-categorias',
            'dataProvider'=>$productos,
            'itemView'=>'_productoMD',
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

    function alerta()
    {
        alert('No puede realizar acciones ya que el producto esta rechazado, diríjase al administrador de variaciones');
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
                    location.reload();
            }
           });
    }
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
                    $('#ac'+id).html('No');
                    $('#ac'+id).removeClass();
                    $('#ac'+id).addClass("red-text");
                }
                else
                {
                    $('#act'+id).html('<i class="glyphicon glyphicon-remove"></i> Desactivar');
                    $('#ac'+id).html('Si');
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
                    $('#ap'+id).html('No');
                    $('#ap'+id).removeClass();
                    $('#ap'+id).addClass("red-text");
                }
                else
                {
                    $('#apr'+id).html("<span class='glyphicon glyphicon-thumbs-down'></span> Rechazar");
                    $('#ap'+id).html('Si');
                    $('#ap'+id).removeClass();
                    $('#ap'+id).addClass("green-text");
                }
            }
           });
       }
       function set_color(id){
           var color =$('#color'+id).val();
           if(color!=0&&color!=""){
           $.ajax({
             url: "<?php echo Yii::app()->createUrl('masterdata/setColor') ?>",
             type: 'POST',
             dataType:"json",
             data:{
                    id:id,
                    color:color
                   },
            success: function (data) {
                
                    $('#co'+id).html(data.html);
                
                
          } });
           
       }}
       function set_padre(id){
            var nombre= $('#padre'+id).val();
            $.ajax({
                     url: "<?php echo Yii::app()->createUrl('producto/verificarPadre') ?>",
                     type: 'POST',
                     dataType:"json",
                     data:{
                            nombre:nombre, 
                           },
                    success: function (data) {
                        if(data.status=='1')
                        {
                              $.ajax({
                                 url: "<?php echo Yii::app()->createUrl('masterdata/setPadre') ?>",
                                 type: 'POST',
                                 dataType:"json",
                                 data:{
                                        id:id,
                                        padre:data.id
                                       },
                                success: function (data2) {
                                    
                                        $('#pa'+id).html(data2.html);
                                        $('#pa'+id).attr("align","left");
                                        location.reload();
                                    
                                    
                              } });
                        }
                        else{
                            $('#crear_padre'+id).show();
                        }
                    }
                   });
  
           }
        
</script>
