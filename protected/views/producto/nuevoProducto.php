<style>
    #caution{
        background: #FFF;
        width: 50%;
        margin: 200px auto;
        height: 500px;
        
    }
        
</style>
<div id="caution" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
   <div class="modal-body" style="width: 100%; height 100%"
       <div class="row-fluid">
           <div class="col-md-3 col-md-offset-2"><a class="btn btn-orange white">Buscar Producto</a></div>
           <div class="col-md-3 col-md-offset-1"><a class="btn btn-darkgray white">Continuar</a></div>
       </div>
    </div>
</div>
<script>
   // $('#caution').modal();
</script>


<?php $this->breadcrumbs=array("Inventario"=>array("producto/productoInventario"),"Cargar inventario"=>array("producto/seleccion"),'Nuevo Producto'); ?> 

<?php

 /*   $cat=new Categoria;
    foreach($cat->getLastChildren() as $key=>$one){
        echo $cat->name($key)." ".count($one)."<br/>";    
        foreach ($one as $item){
            echo "&nbsp;&nbsp;&nbsp;&nbsp;".$cat->name($item);
        }
        echo "<br/><br/>";
    
}*/?>


<?php 
$ppadre=new ProductoPadre;
$producto = new Producto;

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array( 
    'id'=>'producto-padre-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
    'type'=>'horizontal',
    'clientOptions'=>array( 
        'validateOnSubmit'=>false, 
    ),
 
));?>
<h1 class="margin_top margin_bottom">Nuevo Producto</h1>
  <ul id="myTabs" class="nav nav-tabs" role="tablist">
              <li >  <a  id="massive-tab"  aria-controls="home"  href="../masterdata/upload"  >CARGA MASIVA </a></li>
                <li  class="active"><a >CARGA INDIVIDUAL</a></li>
              
              
         <!--    <li role="presentation" class=""><a href="#plantilla" role="tab" id="plantilla-tab" data-toggle="tab" aria-controls="plantilla" aria-expanded="false">DESCARGA DE PLANTILLA</a></li>-->
              
            </ul>
<div class="col-md-6 col-md-offset-3 margin_top_small">
    <div class="margin_top_small">
     <?php echo $form->labelEx($ppadre,'nombre'); ?> 
        <?php


                                     $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                    'id'=>'padre_name',
                                    'name'=>'padre_name',
                                    'source'=>$this->createUrl('ProductoPadre/autocomplete'),
                                    'htmlOptions'=>array(
                                          'size'=>100,
                                          'placeholder'=>'Introduzca nombre del producto',
                                          'class'=>'form-control',
                                          //'maxlength'=>45,
                                        ),
                                    // additional javascript options for the autocomplete plugin
                                    'options'=>array(
                                            'showAnim'=>'fold',
                                    ),
                                    ));
                                    ?>
                                    <span class="help-inline error hide" id="padre_name_em" style="">Debe escribir un nombre o elegir una sugerencia</span>
                                 <input id="padre_id" name="padre_id" value="" type="hidden"/>
    
    
    </div>
    
   <div class="margin_top_small">
        <?php echo $form->labelEx($ppadre,'id_marca'); ?> 
        <?php echo $form->dropDownList($ppadre,'id_marca', CHtml::listData(Marca::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'),array('id'=>'id_marca','class'=>'form-control','empty'=>'Seleccione una marca')); ?>
           <span class="help-inline error hide" id='id_marca_em' style="">Debe elegir una marca</span>
    </div>
    <div class="margin_top_small">
          <?php echo $form->labelEx($producto,'modelo'); ?> 
          <?php echo $form->textField($producto,'modelo',array('class'=>'form-control','maxlength'=>150)); ?>
          <span class="help-inline error hide" id="Producto_modelo_em" style="">Debe indicar un modelo para el producto</span>
     </div>
     <div class="margin_top_small">    
    <label>Categoria<span class="required">*</span></label>
    <select id="categoria" class="form-control">
        <option value="">Seleccione una Categoría</option>
<?php 


    foreach($categorias as $categoria):?>
        
        <option value="<?php echo $categoria->id ?>"><?php echo $categoria->nombre;?></option>
        
<?php    endforeach; ?>


</select>
<span class="help-inline error hide" id="categoria_em" style="">Debe elegir una categoria</span>
</div>
<div class="margin_top_small">   
<label>Subcategoria<span class="required">*</span></label>
<select class="form-control" id="subcategoria" name="ProductoPadre[id_categoria]" disabled="disabled"> 
    <option value=''>Seleccione una Subcategoria</option>   
</select>
<span class="help-inline error hide" id="categoria_em" style="">Debe elegir una subcategoria</span>
</div>
               
                                                                               
                            <div class="margin_top_small">
                                <label>Fabricante</label>
                                <?php echo $form->textField($producto,'fabricante',array('class'=>'form-control','maxlength'=>250)); ?>
                                <?php echo $form->error($producto,'fabricante');  ?>
                            </div>
                            
                            <div class="margin_top_small">
                                <label>Año de fabricacion</label>
                                <?php echo $form->textField($producto,'annoFabricacion',array('class'=>'form-control','maxlength'=>20)); ?>
                                <?php echo $form->error($producto,'annoFabricacion');  ?>
                            </div>

                            
                            <div class="margin_top_small">
                                <label>UPC</label>
                                <?php echo $form->textField($producto,'upc',array('class'=>'form-control','maxlength'=>50)); ?>
                                <?php echo $form->error($producto,'upc'); ?>
                            </div>
                            
                            
                            <div class="margin_top_small">
                                <label>EAN</label>
                                <?php echo $form->textField($producto,'ean',array('class'=>'form-control','maxlength'=>50)); ?>
                                <?php echo $form->error($producto,'ean'); ?>
                            </div>
                            
                            <div class="margin_top_small">
                                <label>GTIN</label>
                                <?php echo $form->textField($producto,'gtin',array('class'=>'form-control','maxlength'=>50)); ?>
                                <?php echo $form->error($producto,'gtin'); ?>
                            </div>
                            
                            <div class="margin_top_small">
                                <label>Numero de parte del Fabricante</label>
                                <?php echo $form->textField($producto,'nparte',array('class'=>'form-control','maxlength'=>50)); ?>
                                <?php echo $form->error($producto,'nparte'); ?>
                            </div>
                            
                            <div class="margin_top_small">
                                <label>Color</label>
                                <div class="row-fluid clearfix">
                                    <div class="col-md-6">

                                        <?php echo $form->dropDownList($producto,'color_id', CHtml::listData(Color::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'),array('id'=>'color_id','class'=>'form-control','empty'=>'Seleccione un Color')); ?>
                                        <?php echo $form->error($producto,'color_id'); ?>
                                        <span class="help-inline error hide" id="color_id_em" style="">Debe elegir un color principal</span>
                                    </div>
                                    <div class="col-md-6">
                                         <?php echo $form->textField($producto,'color',array('class'=>'form-control','maxlength'=>50,'placeholder'=>'Tonalidad del color')); ?>
                                         <?php echo $form->error($producto,'color'); ?>
                                    </div>
                                    
                                    
                                </div>
                               
                            </div>
                            



                        <?php $this->endWidget(); ?>
                    </div>


    
    <div class="col-md-6 col-md-offset-3 margin_top text-center">
            <a class="btn btn-large btn-orange white"  title="Guardar" onclick="submitForm()">Guardar</a>
    </div>
    

<script>
     $('#categoria').change( function(){
        if($(this).val() != ''){
            var path = location.pathname.split('/');
            $.ajax({
                  url: "<?php echo Yii::app()->createUrl('producto/ultimasCategorias'); ?>",
                  type: "post",
                  dataType: "json",
                  data: { padre_id : $(this).val(), as_options: true },
                  success: function(data){
                       $('#subcategoria').html(data.options);
                       $('#subcategoria').removeAttr('disabled');
                      
                  },
            });
        }else{
            $('#subcategoria').html("<option value=''>Seleccione una Subcategoria</option>");
             $('#subcategoria').attr('disabled','disabled');
        }
    });

    $('#padre_name').blur(function(){ 
        var nombre= $(this).val();
        $.ajax({
                 url: "<?php echo Yii::app()->createUrl('producto/verificarPadre') ?>",
                 type: 'POST',
                 dataType:"json",
                 data:{
                        nombre:nombre, 
                       },
                success: function (data) {
                    console.log(data.status);
                    console.log(data);
                    if(data.status=='1')
                    {
                          $('#padre_id').val(data.id);
                    }
                    else{
                        $('#padre_id').val('');
                    }
                }
               })
    });
    
    function submitForm(){
        var resp;  
        var submit = true;
        var field = "";      
        var array =new Array('#color_id','#Producto_modelo','#id_marca','#subcategoria','#categoria','#padre_name');

        for(i=0; i<array.length; i++){
            resp=validate(array[i]);
            submit = resp[0];
            if(resp[1]!='')
                field = resp[1];
        }    
        if(submit){
            $('#producto-padre-form').submit();
        }            
        else{
            $(window).scrollTop($(field).position().top-100);    
        }
        
        
    }
    function validate(id){
        var submit = true;
        var field = id;
        if($(id).val()==''){
            submit=false;
            $(field).addClass('error');
            $(field+'_em').removeClass('hide');
        }else{
            $(field).removeClass('error');
            if(!$(field+'_em').hasClass('hide')){
                $(field+'_em').addClass('hide');
            }
            field="";
        }
        return [submit,field];
    }
    
</script>
