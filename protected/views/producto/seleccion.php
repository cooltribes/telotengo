<!-- CONTENIDO ON --> 
<div class="container">
	<div class="row-fluid">
	<?php
	$this->breadcrumbs=array(

		'Carga Inventario',
	);
	?>

		<?php if(Yii::app()->user->hasFlash('success')){?>
		    <div class="alert in alert-block fade alert-success text_align_center">
		        <?php echo Yii::app()->user->getFlash('success'); ?>
		    </div>
		<?php } ?>
		<?php if(Yii::app()->user->hasFlash('error')){?>
		    <div class="alert in alert-block fade alert-error text_align_center">
		        <?php echo Yii::app()->user->getFlash('error'); ?>
		    </div>
		<?php } ?>

	 <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->

	
</div>
</div>		

<div class="col-md-12 no_horizontal_padding margin_top">
        <h1 class="margin_bottom">Carga de Inventario</h1>
        <div>
            
                               
            <ul id="myTabs" class="nav nav-tabs" role="tablist">
                <li  class="active"><a id="specifications-tab"  aria-controls="home"  aria-expanded="false" href="seleccion" aria-expanded="true">CARGA INDIVIDUAL</a></li>
              <li>  <a href="cargarInbound" id="fileLoad-tab"  >CARGA MASIVA </a></li>
              
           <!--   <li role="presentation" class=""><a href="#plantilla" role="tab" id="plantilla-tab" data-toggle="tab" aria-controls="plantilla" aria-expanded="false">DESCARGA DE PLANTILLA</a></li>-->
              
            </ul>
            

            <div id="myTabContent" class="tab-content">
               

                  <div role="tabpanel" class="tab-pane active in padding_top padding_bottom row-fluid clearfix" id="specifications" aria-labelledby="specifications-tab">
                     <h4 class=" margin_top">Introduzca el nombre del producto que desea buscar</h4>
                    <hr class="dark no_margin_top"/>
                    <div class="col-md-10 well no_radius margin_top">
                        <div class="row-fluid">
                            
                            
                            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                        'id'=>'busqueda-form',
                        'enableAjaxValidation'=>false,
                        'htmlOptions' => array('class' => ''),
                    )); ?>
                
                    
                        <div class="col-md-10 no_padding_right">
                            <?php #echo CHtml::textField("busqueda",'', array('class'=>'form-control no_radius_right no_padding_right','placeholder'=>'Busca el producto que deseas modificar')); ?>
                        
                        <?php
                        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'id'=>'busqueda',
                        'name'=>'busqueda',
                        'source'=>$this->createUrl('Producto/autocomplete'),
                        'htmlOptions'=>array(
                              'size'=>50,
                              'placeholder'=>'Introduzca el nombre del producto que desea buscar',
                              'class'=>'form-control no_radius_right no_padding_right',
                              //'maxlength'=>45,
                            ),
                        // additional javascript options for the autocomplete plugin
                        'options'=>array(
                                'showAnim'=>'fold',
                        ),
                        ));
                      ?>
                      </div> 
                        <div class="col-md-2">
                        <?php $this->widget('bootstrap.widgets.TbButton', array(
                            'buttonType'=>'submit',
                    
                            'label'=>'Buscar',
                            'htmlOptions' => array('class'=>'btn btn-darkgray'),
                        )); ?>
                       </div>   
        
                <?php $this->endWidget();   
            if(Yii::app()->authManager->checkAccess("admin", Yii::app()->user->id))
            {?>
                
                
            <h4> O Agregar un nuevo producto </h4>
            
             <div class="control-group">
                    <?php $this->widget('bootstrap.widgets.TbButton', array(
                'label'=>'Añadir Producto',
                'url' => Yii::app()->baseUrl.'/producto/clasificar',
                'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'htmlOptions' => array('class'=>'btn btn-darkgray'),
            ));  ?>
                </div> 
                <?php
            }
                ?>
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                        </div>
                    </div>
                 
                  </div>
                
       
                
             
            </div>

        
        </div>  
                      
    </div>




<?php   if(isset($dataProvider)){
            $this->renderPartial('busqueda',array('dataProvider'=>$dataProvider)); 
        
        }
?>
	