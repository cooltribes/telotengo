        <?php $this->breadcrumbs=array('Tienda'); ?> 
        <div class="col-md-2 leftPanel no_padding_left">  
           	<?php
           	if(isset( $filter['producto']))
           	{
           	?>
           	 <input type="hidden" id="producto" value="<?php echo  $filter['producto'];?>">  
           	 <?php 
           	 }
           	 ?>             
               <?php $this->renderPartial('filters',array('categorias'=>$categorias,'filter'=>$filter)); ?>
           </div>   
                    
           <div class="col-md-10">
               <div class="row-fluid">
                   <div class="col-md-12 mainStore margin_top_minus no_horizontal_padding ">
                       
                           
                    
                               <?php  
                               $class=$list?'':'row-fluid clearfix';
                         /*      if($list==1)
                                $this->renderPartial('list_view', array('model'=>$model, 'model2'=>$model2));
                               else
							   	$this->renderPartial('grid_view', array('model'=>$model, 'model2'=>$model2)); */
							   	

				   	
							   	
							   	$template = $this->renderPartial('store_controls',array('list'=>$list,'order'=>$order),true).'
      <div class="'.$class.'">
        {items}
      </div>
      <div class="plainSeparator"></div>{pager}      
        ';

            $this->widget('zii.widgets.CListView', array(
            'id'=>'list-auth-productos',
            'beforeAjaxUpdate'=>'function(id,options){$(window).scrollTop($(".list-view").position().top);  }',
            'dataProvider'=>$dataProvider,
            'itemView'=>$list?'list_DP':'grid_DP',
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
                               
                          
                           
                      
                       
                   </div>
               </div> 
           </div>
<script>
		
    function removeLast(string,letter){
         if(string.substring(string.length - 1, string.length)==letter){
            string=string.substring(0, string.length - 1);
        }
        return string;
    }
     function filtrar(){
        var params="?";
        if($("#producto").length > 0){params=params+"producto="+$('#producto').val()+"&"};
        if($('#categoriasFilter').val()!=''){params=params+"categoria="+$('#categoriasFilter').val()+"&";}
            
        if($('#marcasFilter').val()!=''){params=params+"marcas="+$('#marcasFilter').val()+"&";}
            
        if($('#precioFilter').val()!=''){params=params+"precio="+$('#precioFilter').val()+"&";}
        
        if($('#orderBy').val()!=''){params=params+"order="+$('#orderBy').val()+"&";}
        
        if($('#display').val()!=''){params=params+"display="+$('#display').val()+"&";}
            
       // if($('#caracteristicaFilter').val()!=''){params=params+"caracteristica="+$('#caracteristica').val()+"&";}   //TODO para otra entrega        
      
        var url = window.location.href.split("?");
        if(url[0].indexOf('index')==-1){
            if(url[0].substring(url[0].length - 1,url[0].length)!='/'){
                url[0]=url[0]+"/";
            }
            url[0]=url[0]+"index";        
        }
            
        window.location.href=url[0]+removeLast(params,'&'); 
        
    }
    function go(id,value){
        $(id).val(value);
        filtrar();
    }
    function clean(id){
        $(id).val('');
        filtrar();
    }
    function reqCheck(id,value,name){
         if($(id).is(':checked')){
            $('#'+name).val(''+value+'-'+$('#'+name).val()); 
       }                            
       else{
           $('#'+name).val($('#'+name).val().replace(''+value+'-',''));           
        }                       
        $('#'+name).val( removeLast( $('#'+name).val(),'-' ) );   
        $('#marcasFilter').val( removeLast( $('#'+name).val(),'-' ) );    
        filtrar();
    }



 $(function() {
    $( "#slider" ).slider({
      range: true,
      min: 0, 
      max: 5000000,
      values: [<?php echo $filter['precioMenor'] ?> , <?php echo $filter['precioMayor']?> ],

      
      slide: function( event, ui ) {
        $( "#from" ).html(ui.values[ 0 ]);
        $( "#to" ).html(ui.values[ 1 ]); 
        $('#minPrice').val(ui.values[ 0 ]); 
        $('#maxPrice').val(ui.values[ 1 ]); 
      }
    });
    $( "#from" ).html($( "#slider" ).slider( "values", 0 ));
    $( "#to" ).html($( "#slider" ).slider( "values", 1 ));
 
  });
 
</script>