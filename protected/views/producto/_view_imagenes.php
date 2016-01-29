  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
<!-- CONTENIDO ON -->

        <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
        <div class="margin-top">
        			
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
			
		<div class="margin_top">
    	    <div class="row padding_left_small">
                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group">
                        <label for="exampleInputFile">Carga las imágenes aqui</label>
	                            	
						              <?php
						            	$this->widget('CMultiFileUpload', array(
						                'name' => 'url',
						                'remove'=>'Quitar',
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
						            
						            
	                            	
                        </div>                
				</div>
				<div class="col-md-3">
				    <div class="margin_top_small">
                                        <?php $this->widget('bootstrap.widgets.TbButton', array(
                                    'buttonType'=>'submit',
                                    'type'=>'primary',
                                    'label'=>'Cargar imagen(es)',
                                    'htmlOptions'=>array('class'=>'btn-large btn-orange white'), 
                                )); ?> 
                                
                                      </div>
				</div>
			</div>
			
			
					
        </div>
        
        <?php $this->endWidget(); ?>	 

       
        
        <div class="row-fluid clearfix margin_top_large">
        
        	<?php
			$imagenes = $model->imagenes;

			if (count($imagenes) > 0) {
			
			$contador = 0;
        	$lis = array();
 
	        foreach ($imagenes as $key => $img) {
	            $contador++;
                $lis['img_'.$img->id]=   "<div id='img".$img->id."' />".CHtml::image($img->getUrl(array('type'=>'thumb'), "Imagen " . $img->id, array("width" => "100%")))."</div><span>X</span>";
                
				//Yii::app()->baseUrl . str_replace(".","_thumb.",$img->url)
	          /*  $lis['img_' . $img->id] =
	            		'<div class="col-xs-6 col-md-3" id="cont'.$key.'">'.
	                    CHtml::image($img->getUrl(array('type'=>'thumb')), "Imagen " . $img->id, array("width" => "160", "height" => "160")) . 
	                    '<span>X</span><h4> Enlace: </h4>'.
	                    CHtml::textField('Enlace',Yii::app()->getBaseUrl(true).$model->mainimage->url,array('disabled'=>'disabled'))
	                    .'</div>'; */
                        
                   
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
        
         <div class="alert alert-info text-center col-md-12">

          
             Recuerda que la primera imagen será la principal del producto<br/>
            Arrastra las imágenes para ordenar la forma de mostrarlas en tienda
         
        </div>
		</div>

    </div>
    
    <script type="text/javascript">

    $("#ul_imagenes span").on('click',function(){
        var span = $(this);
            
        $.ajax({
            type:"POST",
            url: "<?php echo CController::createUrl('producto/eliminar'); ?>",
            cache:false,
            data: "id="+$(this).parent().attr('id').replace('img_',''),
            success: function(data){

                if(data=='OK'){                        
                    span.parent().fadeOut('medium', function() {
                    span.parent().remove(); // se quita el elemento
                            
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
               }
            });
        })

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

</script>
