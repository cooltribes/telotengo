<?php
$this->breadcrumbs = array(
    'Productos' => array('admin'),
    'Importar',
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
        <h1>Variaciones</h1>
        <div class="moreDetails">
            
                               
            <ul id="myTabs" class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#fileLoad" id="fileLoad-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">CARGA INDIVIDUAL DE </a></li>
              <li role="presentation" class=""><a href="#specifications" role="tab" id="specifications-tab" data-toggle="tab" aria-controls="specifications" aria-expanded="false">CARACTERÍSTICAS GENERALES</a></li>
              <li role="presentation" class=""><a href="#plantilla" role="tab" id="plantilla-tab" data-toggle="tab" aria-controls="plantilla" aria-expanded="false">RECOMENDACIONES DEL PRODUCTO</a></li>
              
            </ul>
            
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
                <div role="tabpanel" class="tab-pane active in row-fluid clearfix" id="fileLoad" aria-labelledby="home-tab">
                    <h4 class=" margin_top">1.- Realizar la validación previa del archivo:</h4>
                    <hr class="dark no_margin_top"/>
                    <div class="col-md-8 well no_radius">
                        <div class="row-fluid">
                            <?php
                            $this->widget('CMultiFileUpload', array(
                                'name' => 'archivoValidacion',
                                'accept' => 'xls|xlsx', // useful for verifying files
                                'duplicate' => 'El archivo está duplicado.', // useful, i think
                                'denied' => 'Tipo de archivo inválido.', // useful, i think
                                'htmlOptions'=>array('class'=>'col-md-10')
                            ));
                            ?>
                            
                                             
                                <?php
                                $this->widget('bootstrap.widgets.TbButton', array(
                                    'buttonType' => 'submit',
   
                                    'label' => 'Validar',
                                    'icon' => 'ok white',
                                    'htmlOptions' => array(
                                        'name' => 'validar',
                                        'class'=>'col-md-2 btn-darkgray'
                                    ),
                                ));
                                ?>
                        </div>
                        
                        
                            
                        
                            
                    </div>
                    
                   <div class="col-md-4" style="display:block; height:120px"></div>
                    
                    
                    
                    <h4 class="margin_top">2.- Subir archivo previamente validado:</h4>
                    <hr class="dark no_margin_top"/>
                    <div class="col-md-8 well no_radius">
                         <div class="row-fluid">  
                            <?php
                            $this->widget('CMultiFileUpload', array(
                                'name' => 'archivoCarga',
                                'accept' => 'xls|xlsx', // useful for verifying files
                                'duplicate' => 'El archivo está duplicado.', // useful, i think
                                'denied' => 'Tipo de archivo inválido.', // useful, i think
                                'htmlOptions'=>array('class'=>'col-md-9')
                            ));
                            ?>
        
                                         
                                <?php
                                $this->widget('bootstrap.widgets.TbButton', array(
                                    'buttonType' => 'submit',
     
      
                                    'label' => 'Cargar Masterdata',
                                    'loadingText'=>'Cargando ...',
                                    'htmlOptions' => array(
                                        'name' => 'cargar',
                                        'id'=>'buttonCargaMD',
                                        'class'=>'col-md-3 btn-orange orange_border white'
                                    ),
                                ));
                                ?>
                            </div>
                      </div>
                      
                </div>
          
                  <div role="tabpanel" class="tab-pane padding_top padding_bottom row-fluid clearfix" id="specifications" aria-labelledby="specifications-tab">
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
                    <h4 class=" margin_top">Descargar archivo Excel para generar el Masterdata</h4>
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
                     <p> <?php
                        if ($nuevos > 0 || $actualizados > 0) {
                            echo "<h3>Datos del archivo cargado:</h3>";            
                            echo "<h4>Nombre: <b>" . $fileName . "</b></h4>";
                            echo "<h4>Total de productos que contiene: <b>" . ($nuevos + $actualizados) . "</b></h4>";
                            echo "<h4>Productos (Combinación con SKU) nuevos: <b>" . $nuevos . "</b></h4>";
                            echo "<h4>Productos (Combinación con SKU) actualizados: <b>" . $actualizados . "</b></h4><br><hr><br>";
                            
                        }
                        ?></p>      
                                    
                </div>
             
            </div>
 <?php $this->endWidget(); ?>
        
        </div>  
                      
    </div>




