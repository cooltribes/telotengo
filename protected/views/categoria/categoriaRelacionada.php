<!-- FLASH ON -->
<script>
    var related = new Array();
    
</script>
<?php 

 $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'categoria-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true, 
	),
	'htmlOptions'=>array('class'=>'form-stacked form-horizontal','enctype' => 'multipart/form-data'),
));

?>

<input id="accion" type="hidden" value="" />	


<div class="container margin_top">
  <div class="page-header">
    <h1>Categorias Relacionadas</small></h1>
    <h2 ><?php echo $model->nombre?></h2>
  </div>
  <!-- SUBMENU ON -->
  <input id="categoria" type="hidden" value="<?php echo $model->id ?>" />
  <?php echo $this->renderPartial('menu', array('model'=>$model,'opcion'=>5)); ?> 
  <!-- SUBMENU OFF -->
  <?php 
  Yii::app()->session['id']=$model->id;
$this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )
); 

  ?>
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3  margin_bottom_small padding_small box_1">
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked form-horizontal" enctype="multipart/form-data">
          <fieldset>
            
            <legend>Listado de Categorías</legend>
            <div class="span6">
              <?php
               $cat = Categoria::model()->findAllByAttributes(array('id_padre'=>'0'));


		if(count($model) > 0){
			foreach($model as $indiv)
			{
				if(isset($indiv->tbl_categoria_id))	
					{echo("<input class='idsCategorias' type='hidden' value='".$indiv->tbl_categoria_id."' />");
					}
			}		
		}

		nodos($cat,$model->id);
		
			function nodos($items,$id){
				echo "<ul class='no_bullets'>";
				foreach ($items as $item){
						 $verificar=CategoriaRelacion::model()->areRelated(Yii::app()->session['id'],$item->id);
						if($id != $item->id)
                         {  
                            if($verificar==0)   
                                echo "<li><label><input class='itemCheck' id='cat-".$item->id."' type='checkbox' value='".$item->id."' /> ".$item->nombre."</label></li>";
                            else
                                echo "<li><label><input class='itemCheck' id='cat-".$item->id."' type='checkbox' value='".$item->id."' checked /> ".$item->nombre."</label></li>";
                            if ($item->hasChildren()){
                                nodos($item->getChildren(),$id);
                            }
                         }
					}
				echo "</ul>";
				return 1;
			}

     ?>
            </div>
          </fieldset>
        </form>
      </div>
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
    
    
    <input id="accion" type="hidden" value="" />	
        	
        	 
        	
        	
          <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'ajaxButton',
			'type'=>'danger',
			'label'=>'Guardar',
			'url'=>array('categoria/catRela'), // ReCatProd Relacion Categorias a producto
			'htmlOptions'=>array('id'=>'guardar','class'=>'btn-large btn-block'),
			'ajaxOptions'=>array(
			'type' => 'POST',
			'beforeSend' => "function( request )
			{
				 var checkValues = $(':checkbox:checked').map(function() {
			        return this.id;
			    }).get().join();

			    $('#accion').attr('value', 'normal');
			    var accion = $('#accion').attr('value');
			    
			   // alert(checkValues); 
				var categoria = $('#categoria').attr('value'); 
			
			this.data += '&categoria='+categoria+'&check='+related+'&accion='+accion;
			}",
			
			'data'=>array('a'=>'5'),
			'success'=>"function(data){
				
				
					//window.location.reload();
				
			}",
			),
			)); ?>
			
			<button id="avanzar" style="cursor: pointer" class="btn btn-block boton_link transition_all btn" title="Guardar y avanzar">Guardar y avanzar
     
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
<?php $this->endWidget(); ?>
<script>
	$(document).ready(function(){
	
	jQuery.each($('.idsCategorias'), function() {

		var id = $(this).attr('value');
    	$('#cat-'+id).attr('checked',true);
   	});	
   	
       	$('.itemCheck').click(function(event){ 
        
            if($(this).is(':checked')){
                if(related.indexOf($(this).val())==-1){
                    related.push($(this).val());
                }   
            }else{
                if(related.indexOf($(this).val())!=-1){
                    related.splice(related.indexOf($(this).val()),1);
                } 
                
            }
        });
        
        	
		
	               
	});
	
    
	
</script> 