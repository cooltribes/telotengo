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

                    if(data=='OK'){
                        
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
                    
                    }else{

                    }
                    
                
                    
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

<!-- CONTENIDO ON -->
     <div class="container-fluid" style="padding: 0 15px;">
			
      <div class="row">

        <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->

        <div class="col-md-10 col-md-push-2 main-content" role="main">
        	
        			
		<?php
		$this->breadcrumbs=array(
			'Productos'=>array('admin'),
			'Imágenes',
		);
		
		?>
        	
          <h1>Imágenes<small> - Registar nuevo producto</small></h1>

		 <?php echo $this->renderPartial('_menu', array('model'=>$model,'activo'=>'imagenes')); ?>
		
		
		  <!-- SUBMENU ON --> 
		 
		  <?php 
		  
		   Yii::app()->clientScript->registerScript('form_sending', "
		            $('#producto-form').submit(function(){
		                $('#wrapper_content').addClass('loading');
		            });
		            ");
		  
		  $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'action' => CController::createUrl('producto/multi', array('id' => $model->id)),
			'id'=>'producto-form',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('enctype' => 'multipart/form-data'),
		)); ?>
			
          <div class="well">
            <div class="row padding_left_small">
                <div class="col-md-6 1">
                        <div class="form-group">
	                            <label for="exampleInputFile">Cargue o agregue las imagenes aqui</label>
	                            	
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
									'type'=>'primary',
									'label'=>'Subir imagen',
									'htmlOptions'=>array('class'=>'btn-lg'),
								)); ?>
								
						              </div>
	                            	
                        </div>                
				</div>
			</div>		
        </div>
        
        <?php $this->endWidget(); ?>	

        <div class="well well-small">
          <h3>Instrucciones:</h3>
          <ul>
            <li> Ten en cuenta que la primera imagen será la principal del producto</li>
            <li>Arrastra las imágenes para organizarlas</li>
          </ul>
        </div>
        
        <div class="row">
        
        	<?php
			$imagenes = $model->imagenes;

			if (count($imagenes) > 0) {
			
			$contador = 0;
        	$lis = array();

	        foreach ($imagenes as $img) {
	            $contador++;
				//Yii::app()->baseUrl . str_replace(".","_thumb.",$img->url)
	            $lis['img_' . $img->id] =
	            		'<div class="col-xs-6 col-md-3">'.
	                    CHtml::image($img->getUrl(array('type'=>'thumb')), "Imagen " . $img->id, array("width" => "240", "height" => "240",'class'=>'thumbnail')) . 
	                    '<span>X</span><h4> Enlace: </h4>'.
	                    CHtml::textField('Enlace',Yii::app()->getBaseUrl(true).$img->getUrl(),array('disabled'=>'disabled'))
	                    .'</div>'; 
			}			

	        $this->widget('zii.widgets.jui.CJuiSortable', array(
	            'items' => $lis,
	            'options' => array(
	                'delay' => '300',
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
		
  </div>
  
  </div>
<!-- /container --> 