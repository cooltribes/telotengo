<script type="text/javascript">
    $(document).ready(function(){
var uno=0;

        $("#ul_imagenes span").live('click',function(){

            var span = $(this);
			
            $.ajax({
                type:"POST",
                url: "<?php echo CController::createUrl('producto/eliminar'); ?>",
                cache:false,
               	data: "id="+$(this).parent().parent().attr('id').replace('img_',''),
                success: function(data){

                   
                        
                        span.parent().parent().fadeOut('medium', function() {
						    // Animation complete.
						    span.parent().parent().remove(); // se quita el elemento
						    
						    var order = $("#ul_imagenes").sortable("serialize") + '&action=actualizar_orden';
								
					    	$.ajax({
		                        type:"POST",
		                        url: "<?php echo CController::createUrl('producto/orden'); ?>",
		                        cache:false,
		                        data: order,
		                        success: function(data){
		
		                            $("#respuesta").empty();
		                            $("#respuesta").html(data);
		                        }
		                   });
					    
					  });
                    
                    
                
                    
               }
            });
			
        })

        $(function() {
            $("#ul_imagenes").sortable({
                opacity: 0.3,
                cursor: 'move',
                update: function() {
 
                    //alert("movi");

                    var order = $(this).sortable("serialize") + '&action=actualizar_orden';
                    //alert(order);

                    $.ajax({
                        type:"POST",
                        url: "<?php echo CController::createUrl('producto/orden'); ?>",
                        cache:false,
                        data: order,
                        success: function(data){

                            $("#respuesta").empty();
                            $("#respuesta").html(data);
                        }
                    });
                }
            });
        });

    });
</script>
<?php
$this->breadcrumbs=array(
	'Productos'=>array('admin'),
	'Imágenes',
);

?>

<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Producto - Imágenes</small></h1>
    <h2 ><?php echo $model->nombre."  [<small class='t_small'>Ref: </small>]"; ?></h2>
  </div>
  <!-- SUBMENU ON --> 
  
  <?php echo $this->renderPartial('menu_agregar_producto', array('model'=>$model,'opcion'=>4)); ?>
  <?php 
  
   Yii::app()->clientScript->registerScript('form_sending', "
            $('#producto-form').submit(function(){
                $('#wrapper_content').addClass('loading');
            });
            ");
  
  $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action' => CController::createUrl('Producto/multi', array('id' => $model->id)),
	'id'=>'producto-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
  
  
  <?php
	echo CHtml::hiddenField('accion','def', array('id' => 'accion'));
	//<input id="accion" type="hidden" value="" />	

?>

  
  <!-- SUBMENU OFF -->
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        <form enctype="multipart/form-data" class="form-stacked personaling_form" id="registration-form" action="/aiesec/user/registration?template=1" method="post">
          <fieldset>
            <legend>Subir imágenes del producto: </legend>
            <div class="well well-large">
              <?php
            	$this->widget('CMultiFileUpload', array(
                'name' => 'url',
                'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
                'duplicate' => 'El archivo está duplicado.', // useful, i think
                'denied' => 'Tipo de archivo invalido.', // useful, i think
                'htmlOptions' => array('multiple' => 'multiple'),
                'options'=>array(
                    'onFileSelect'=>'function(e, v, m){ console.log("onFileSelect - "+v+"\nm: "+m+"\ne: "+e); 
                       console.log(m); }',
                    'afterFileSelect'=>'function(e, v, m){ console.log("afterFileSelect - "+v) 
                        console.log(m);}',
                    'onFileAppend'=>'function(e, v, m){ console.log("onFileAppend - "+v); console.log(m); }',
                    'afterFileAppend'=>'function(e, v, m){ console.log("afterFileAppend - "+v); console.log(m);}',
                    'onFileRemove'=>'function(e, v, m){ console.log("onFileRemove - "+v) }',
                    'afterFileRemove'=>'function(e, v, m){ console.log("afterFileRemove - "+v) }',
                 )
            ));
			
			?>
              <?php echo $form->error($imagen, 'url'); ?>
              <div class="margin_top_small">
                <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'danger',
			'label'=>'Subir imagen',
		)); ?>
              </div>
            </div>
            <?php $this->endWidget(); ?>
          </fieldset>
        </form>
        <hr/>
        <div class="well well-small">
          <h3>Instrucciones:</h3>
          <ul>
            <li> Ten en cuenta que la primera imagen será la principal del producto</li>
            <li>Arrastra las imágenes para organizarlas</li>
             <li>Se debe seleccionar un color a la foto del producto, ya que de no hacerlo no se mostrara en la tienda.</li>
          </ul>
        </div>
        <div class="clearfix productos_del_look">
          <?php
			$imagenes = $model->imagenes;

			if (count($imagenes) > 0) {
			
			$contador = 0;
        	$lis = array();

	        foreach ($imagenes as $img) {
	            $contador++;
				//Yii::app()->baseUrl . str_replace(".","_thumb.",$img->url)
	            $lis['img_' . $img->id] =
	            		'<div >'.
	                    CHtml::image($img->getUrl(array('type'=>'thumb')), "Imagen " . $img->id, array("width" => "150", "height" => "150")) . 
	                    '<span>X</span>'.
	                    '<div class="metadata_top">'.
	                    
	                    '</div></div>'; 
						

			}			


	        $this->widget('zii.widgets.jui.CJuiSortable', array(
	            'items' => $lis,
	            'options' => array(
	                'delay' => '100',
	            ),
	            'htmlOptions' => array(
	                'id' => 'ul_imagenes',
	                'class' => 'grid_imagenes',
	            )
	        ));
	        ?>
          <?php
			}
        
        ?>
        </div>
      </div>
      </ul>
    </div>
    <div class="span3">
      <div class="padding_left"> 
        <!-- SIDEBAR OFF --> 
        <script > 
			// Script para dejar el sidebar fijo Parte 1
			function moveScroller() {
				var move = function() {
					var st = $(window).scrollTop();
					var ot = $("#scroller-anchor").offset().top;
					var s = $("#scroller");
					if(st > ot) {
						s.css({
							position: "fixed",
							top: "70px"
						});
					} else {
						if(st <= ot) {
							s.css({
								position: "relative",
								top: "0"
							});
						}
					}
				};
				$(window).scroll(move);
				move();
			}
		</script>
        <div id="scroller-anchor"></div>
        <div id="scroller">
          <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'danger',
			'size' => 'large',
			'block'=>'true',
			'htmlOptions' => array('id'=>'normal'),
			'label'=>'Guardar',
		)); ?>
          <ul class="nav nav-stacked nav-tabs margin_top">
             <li><a href="../seo/<?php echo $model->id; ?>" id="avanzar" title="Guardar y avanzar" id="limpiar">Guardar y avanzar</a></li>
          </ul>
        </div>
      </div>
      <script type="text/javascript"> 
		// Script para dejar el sidebar fijo Parte 2
			$(function() {
				moveScroller();
			 });
		</script> 
      <!-- SIDEBAR OFF --> 
      
    </div>
  </div>
</div>
<!-- /container --> 
<script type="text/javascript">
// here is the magic
function addColor(id)
{
	var image_id = id;
	var color_id = $("#color_id"+id).val(); 
	//alert($(this).val());
    <?php echo CHtml::ajax(array(
            'url'=>array('producto/imagenColor'),
           // 'data'=> "js:$(this).serialize()",
           'data' => array('id'=>'js:image_id','color_id'=>'js:color_id'),
            'type'=>'post',
            'dataType'=>'json',
           /*
		    'success'=>"function(data)
            {
                if (data.status == 'failure')
                {
                    $('#dialogColor div.divForForm').html(data.div);
                          // Here is the trick: on submit-> once again this function!
                    $('#dialogColor div.divForForm form').submit(addColor);
                }
                else
                {
                    $('#dialogColor div.divForForm').html(data.div);
                    setTimeout(\"$('#dialogColor').modal('hide') \",3000);
                }
 
            } ",*/
            ))?>;
    return false; 
 
}


	$('#normal').on('click', function(event) {
		event.preventDefault();
		
		// cambio el valor
		$("#accion").attr("value", "normal");
		//alert( $("#accion").attr("value") );
		
		// submit del form
		$('#producto-form').submit();
		
		}
	);
	
	$('a#siguiente').on('click', function(event) {
		
		event.preventDefault();
		
		$("#accion").attr("value", "siguiente");
		var uno = $("#id_sig").attr("value");
		
		if(uno != ""){
			//alert(uno);

			// submit del form
			$('#producto-form').submit();
		}
	}	
	);	
	
	/*
	$('a#avanzar').on('click', function(event) {
		
		event.preventDefault();
		
		$("#accion").attr("value", "avanzar");
		//alert( $("#accion").attr("value") );
		
		// submit del form
		$('#producto-form').submit();
		
		}
	);
 */
</script> 
