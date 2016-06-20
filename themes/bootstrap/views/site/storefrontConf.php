<?php
$this->breadcrumbs=array(
    "Site" => array("/categoria/admin"),
    "Storefront GENERAL" 
);
?> 
<div class="col-md-12" >
    <div class="row-fluid">
        <div class="col-md-12 margin_top_small subcategory">          
            <div class="row-fluid title clearfix margin_bottom_small">
                <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div>
                <div class="col-md-8 no_horizontal_padding text-center"><h1>Superior</h1></div>
                <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div> 

            </div>
             <div onclick="js:modal(1,false);">
                              
                              <?php echo CHtml::image(Funciones::getBanner(1,2), 'asd',array('width'=>'1200','height'=>'300'));?>
                             <!-- <span class="imgNumber">1</span>-->
             </div>
             <br>
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
<div id="toLoad" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; min-height: 600px;">
 
</div>

<script>


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


  