<?php
$this->breadcrumbs = array(
    'Carga Inventario',
);
?>
<!-- FLASH ON --> 
<?php
$this->widget('bootstrap.widgets.TbAlert', array(
    'block' => true, // display a larger alert block? 
    'fade' => true, // use transitions?
    'closeText' => '&times;', // close link text - if set to false, no close link is displayed
    'alerts' => array(// configurations per alert type
        'success' => array('block' => true, 'fade' => true, 'closeText' => '&times;'), // success, info, warning, error or danger
        'error' => array('block' => true, 'fade' => true, 'closeText' => '&times;'), // success, info, warning, error or danger
    ),
        )
);
?>  
<!-- FLASH OFF --> 


<script type="text/javascript">

$('#buttonCargaMD').click(function(e) {
    var btn = $(this);
    var res = confirm("El archivo será cargado.\n¿Estás seguro de que ha sido validado ya?");
    if (res == true) {
        btn.button('loading'); // call the loading function
        $("body").addClass("aplicacion-cargando");
       
    } else {
       e.preventDefault();
    }
    
});

</script>



<div class="col-md-12 no_horizontal_padding margin_top">
        <h1 class="margin_bottom">Carga de Productos</h1>
  
          <ul id="myTabs" class="nav nav-tabs" role="tablist">
              <li class="active">  <a  id="fileLoad-tab"  >CARGA MASIVA </a></li>
                <li  ><a id="individual-tab"  aria-controls="home"  href="../producto/nuevoProducto">CARGA INDIVIDUAL</a></li>
              
              
         <!--    <li role="presentation" class=""><a href="#plantilla" role="tab" id="plantilla-tab" data-toggle="tab" aria-controls="plantilla" aria-expanded="false">DESCARGA DE PLANTILLA</a></li>-->
              
            </ul>
        
        
        <div>
            
     <?php
            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    //'action' => CController::createUrl('importar'),
                    'id' => 'form-validar',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('enctype' => 'multipart/form-data'),
                ));
                
            ?>
            <div id="myTabContent" class="tab-content">

                <div role="tabpanel" class="tab-pane active in" id="fileLoad" aria-labelledby="home-tab">
                    <div class="row-fluid clearfix">
                        <div class="col-md-6">
                            <h4 class=" margin_top no_margin_bottom">1.- Realizar la validación previa del archivo:</h4>
                        </div>
                        <div class="col-md-6 margin_top_small ">
                             <a href="<?php echo Yii::app()->getBaseUrl(true)."/docs/xlsMasterData/TLT-Masterdata.xlsx"; ?>" class="btn btn-darkgray"> <span class="glyphicon glyphicon-download-alt"></span> Descargar Archivo</a>
                        </div>
                        <div class="col-md-12 no_horizontal_padding margin_top_minus">
                            <hr class="dark"/>
                        </div>
                        
                        <div class="col-md-8 well no_radius">
                               <form method="post" enctype="multipart/form-data">
                            <div class="row-fluid">
                                <div class="col-md-10">

                                <input type="file" name="validar" id="validar" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                </div>
                                                 
                                    <?php
                                    $this->widget('bootstrap.widgets.TbButton', array(
                                        'buttonType' => 'submit',
       
                                        'label' => 'Validar',
                                        'icon' => 'ok white',
                                        'htmlOptions' => array(
                                            'name' => 'btn-validar',
                                             'id' => 'btn-validar',
                                            
                                            'class'=>'col-md-2 btn-darkgray',
                                              
                                        ),
                                    ));
                                    ?>
                            </div>
                            
                            
                                
                            
                                
                        </form>
                       </div> 
                       <div class="col-md-4" style="display:block; height:120px"></div>
                 <?php  if($summary==1):?>
                        <b><u>Resumen:</u></b><br/>
                        <div class="col-md-12">
                          
                               Errores encontrados: <?php echo $resumen["errores"]; ?><br/>
                           
                           <?php echo $resumen["resumen"]; ?>    
                       </div>
                 <?php endif; ?>
                    </div>
                    <div class="row-fluid clearfix">
                    
                        <h4 class="margin_top">2.- Subir archivo previamente validado:</h4>
                        <hr class="dark no_margin_top"/>
                         <div class="col-md-8 well no_radius">
                         <form  method="post" enctype="multipart/form-data">
                             <div class="row-fluid">  
                                 <div class="col-md-9">
                                 
                                <input type="file" name="cargar" id="cargar" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                    </div>
                                             
                                    <?php
                                    $this->widget('bootstrap.widgets.TbButton', array(
                                        'buttonType' => 'submit',
         
          
                                        'label' => 'Cargar Inbound',
                                        'loadingText'=>'Cargando ...',
                                        'htmlOptions' => array(
                                            'name' => 'cargar',
                                            'id'=>'buttonCargaMD',
                                            'class'=>'col-md-3 btn-orange orange_border white',
                                                                ),
                                    ));
                                    ?>
                                </div>
                          </form>
                      </div>
                          <div class="col-md-4" style="display:block; height:120px"></div>
                           <?php  if($summary==2):?>
                       <b><u>Resumen:</u></b><br/>
                        <div class="col-md-12">
                          
                               Errores encontrados: <?php echo $resumen["errores"]; ?><br/>
                           
                           <?php echo $resumen["resumen"]; ?>    
                       </div>
                 <?php endif; ?>
                      </div>
                </div>
          
             <!--       <div role="tabpanel" class="tab-pane padding_top padding_bottom row-fluid clearfix" id="specifications" aria-labelledby="specifications-tab">
                     <h4 class=" margin_top">Introduzca el nombre del producto que desea buscar</h4>
                    <hr class="dark no_margin_top"/>
                    <div class="col-md-10 well no_radius">
                        <div class="row-fluid">
                            <div class="col-md-11">
                                <input class="form-control no_radius"/>
                            </div>
                            <a class="col-md-1 btn btn-darkgray" href="#">
                                Buscar
                            </a>
                        </div> 
                    </div>
                 
                  </div>
                
              <div role="tabpanel" class="tab-pane row-fluid clearfix" id="plantilla" aria-labelledby="plantilla-tab">
                    <h4 class=" margin_top">Descargar archivo Excel para generar el Inbound</h4>
                    <hr class="dark no_margin_top"/>
                    <div class="col-md-6 well no_radius">
                        <div class="row-fluid">
                            <div class="col-md-6">
                              <select class="form-control">
                                    <option>Seleccionar Categoría</option>
                                </select>
                            </div>
                            <div class="col-md-6 text-center">
                                 <a href="../site/plantillaExternos" class="btn btn-darkgray"> <span class="glyphicon glyphicon-download-alt"></span> Descargar Archivo</a>
                            </div>
                        </div>
                    </div> 
                          
                                    
                </div>-->
                
             
            </div>
 <?php $this->endWidget(); ?>
        
        </div>  
                      
    </div>




