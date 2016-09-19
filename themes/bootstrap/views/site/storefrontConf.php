<?php
$this->breadcrumbs=array(
    "Site" => array("/categoria/admin"),
    "Storefront GENERAL" 
);
?> 
  <ul id="myTabs" class="nav nav-tabs margin_top" role="tablist">
    <li id="compradorNav" class="nav active"><a onclick="cambiar(1)" href="#"  aria-expanded="false">Comprador</a></li>
    <li id="vendedorNav" class="nav"><a onclick="cambiar(2)" href="#" aria-controls="home" aria-expanded="true">Vendedor</a></li>
    <li id="generalNav" class="nav"><a onclick="cambiar(3)" href="#" aria-controls="home" aria-expanded="true">General</a></li>
                
  </ul>
<div class="col-md-12 margin_bottom_large" >
    <div class="row-fluid">
        <div class="col-md-12 margin_top_large subcategory">          
            <div class="comprador">
              <div class="row-fluid title clearfix margin_bottom_small">
                  <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div>
                  <div class="col-md-8 no_horizontal_padding text-center"><h1>Superior 1 Comprador</h1></div>
                  <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div> 

              </div>
               <div onclick="js:modal(1,false);">
                                
                                <?php echo CHtml::image(Funciones::getBanner(1,2), 'asd',array('width'=>'1200','height'=>'300'));?>
                               <!-- <span class="imgNumber">1</span>-->
               </div>
               <br>            
               <div class="row-fluid title clearfix margin_bottom_small">
                  <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div>
                  <div class="col-md-8 no_horizontal_padding text-center"><h1>Superior 2 Comprador</h1></div>
                  <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div> 

              </div>
               <div onclick="js:modal(4,false);">
                                
                                <?php echo CHtml::image(Funciones::getBanner(4,2), 'asd',array('width'=>'1200','height'=>'300'));?>
                               <!-- <span class="imgNumber">1</span>-->
               </div>
               <br>
                <div class="row-fluid title clearfix margin_bottom_small">
                  <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div>
                  <div class="col-md-8 no_horizontal_padding text-center"><h1>Superior 3 Comprador</h1></div>
                  <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div> 

              </div>
               <div onclick="js:modal(5,false);">
                                
                                <?php echo CHtml::image(Funciones::getBanner(5,2), 'asd',array('width'=>'1200','height'=>'300'));?>
                               <!-- <span class="imgNumber">1</span>-->
               </div>
             </div>

             <div class="vendedor hide">
              <div class="row-fluid title clearfix margin_bottom_small">
                  <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div>
                  <div class="col-md-8 no_horizontal_padding text-center"><h1>Superior 1 Vendedor</h1></div>
                  <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div> 

              </div>
               <div onclick="js:modal(6,false);">
                                
                                <?php echo CHtml::image(Funciones::getBanner(6,2), 'asd',array('width'=>'1200','height'=>'300'));?>
                               <!-- <span class="imgNumber">1</span>-->
               </div>
               <br>            
               <div class="row-fluid title clearfix margin_bottom_small">
                  <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div>
                  <div class="col-md-8 no_horizontal_padding text-center"><h1>Superior 2 Vendedor</h1></div>
                  <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div> 

              </div>
               <div onclick="js:modal(7,false);">
                                
                                <?php echo CHtml::image(Funciones::getBanner(7,2), 'asd',array('width'=>'1200','height'=>'300'));?>
                               <!-- <span class="imgNumber">1</span>-->
               </div>
               <br>
                <div class="row-fluid title clearfix margin_bottom_small">
                  <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div>
                  <div class="col-md-8 no_horizontal_padding text-center"><h1>Superior 3 Vendedor</h1></div>
                  <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div> 

              </div>
               <div onclick="js:modal(8,false);">
                                
                                <?php echo CHtml::image(Funciones::getBanner(8,2), 'asd',array('width'=>'1200','height'=>'300'));?>
                               <!-- <span class="imgNumber">1</span>-->
               </div>
                <br>
                <div class="row-fluid title clearfix margin_bottom_small">
                  <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div>
                  <div class="col-md-8 no_horizontal_padding text-center"><h1>Superior 4 Vendedor</h1></div>
                  <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div> 

              </div>
               <div onclick="js:modal(9,false);">
                                
                                <?php echo CHtml::image(Funciones::getBanner(9,2), 'asd',array('width'=>'1200','height'=>'300'));?>
                               <!-- <span class="imgNumber">1</span>-->
               </div>
             </div>
          
             <div class="general hide">
               <div class="row-fluid title clearfix margin_bottom_small">
                  <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div>
                  <div class="col-md-8 no_horizontal_padding text-center"><h1>Lateral Derecho 1</h1></div>
                  <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div>   
              </div>
                  <div class="col-md-12 col-md-offset-4" onclick="js:modal(2,false);">
                                
                                <?php echo CHtml::image(Funciones::getBanner(2,2), 'asd',array('width'=>'294','height'=>'318'));?>
                                  <!-- <span class="imgNumber">1</span>-->
                  </div>
               <br>
                <div class="row-fluid title clearfix margin_bottom_small">
                    <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div>
                    <div class="col-md-8 no_horizontal_padding text-center"><h1>Lateral Derecho 2</h1></div>
                    <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div>   
                </div>
                    <div class="col-md-12 col-md-offset-4" onclick="js:modal(3,false);">
                                
                                <?php echo CHtml::image(Funciones::getBanner(3,2), 'asd',array('width'=>'294','height'=>'318'));?>
                                <!-- <span class="imgNumber">1</span>-->
                    </div>  
              </div>  
        </div>

    </div>
    
</div>
<div id="toLoad" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; min-height: 600px;">
 
</div>

<script>

function cambiar(opcion)
{
  var add,remove, remove2;
  if(opcion==1)
  {
    remove="vendedor";
    remove2="general";
    add="comprador";
  }
  if(opcion==2)
  {
    remove="comprador";
    remove2="general";
    add="vendedor";
  }
  if(opcion==3)
  {
    remove="comprador";
    remove2="vendedor";
    add="general";
  }

  $('.'+remove).addClass('hide');
  $('#'+remove+'Nav').removeClass('active');
  $('.'+remove2).addClass('hide');
  $('#'+remove2+'Nav').removeClass('active');

  $('.'+add).removeClass('hide');
  $('#'+add+'Nav').addClass('active');
  
}

function modal(index, confirm){ 
        //var group = 1;
       // var type= 3;
        //var name = 'categoria';
       
      $.ajax({ 
                      url: "../formConfImage",
                      type: "post",
                      datatype:'json',
                      data: {
                      //  categoria_id: category,
                       // name:name,
                        index:index,
                       // group:group,
                        //type:type,
                        confirm:confirm,
                        
                        
                         },
                      success: function(data){
                         
                          var obj=JSON.parse(data);
                          if(!obj.confirm||!confirm){
                              $('#toLoad').html(obj.form);    
                              $('#toLoad').modal(); 
                          }else{
                              if(confirm("Al cargar una imagen sobrescribirás la actual. ¿Deseas sobrescribir la imagen?")){
                                  $('#toLoad').html(obj.form);    
                                  $('#toLoad').modal(); 
                              }
                          }
                                              
                      },
                      error:function(){
                  
                      }
                });
}    
    
    
</script>  

<?php echo isset($_GET['index'])?'<script>modal('.$_GET['index'].',false)</script>':''; ?>


  