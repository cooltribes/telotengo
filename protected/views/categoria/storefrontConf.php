<?php
$this->breadcrumbs=array(
    "Categorías" => array("/categoria/admin"),
    $model->nombre => array(Yii::app()->baseUrl."/categoria/create".$model->id),
    "Storefront" 
); 
?> 
<div class="col-md-6 col-md-offset-3 margin_bottom_large" >
    <div class="row-fluid">
        <div class="col-md-12 margin_top_small subcategory">          
            <div class="row-fluid title clearfix margin_bottom_small">
                <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div>
                <div class="col-md-8 no_horizontal_padding text-center"><h1><?php echo $model->nombre?></h1></div>
                <div class="col-md-2 no_horizontal_padding"><div class="braker"></div></div>                
            </div>
             <div onclick="js:modal(1,false);">
                              <?php echo $imConf->getImage($name='categoria',$index=1, $categoria_id=$model->id);?>
                              <span class="imgNumber">1</span>
             </div>
            
        </div>
        <div class="col-md-12 no_horizontal_padding">
            <div class="row-fluid">
           
                    <div onclick="js:modal(2,false);" class="col-md-4 col-sm-4 col-xs-4 margin_top subcat" >
                              <?php echo $imConf->getImage($name='categoria',$index=2, $categoria_id=$model->id);?>
                              <span class="imgNumber small">2</span>
                    </div>
                    <div onclick="js:modal(3,false);" class="col-md-4 col-sm-4 col-xs-4 margin_top subcat" >
                              <?php echo $imConf->getImage($name='categoria',$index=3, $categoria_id=$model->id);?>
                              <span class="imgNumber  small">3</span>
                    </div>
                    <div onclick="js:modal(4,false);" class="col-md-4 col-sm-4 col-xs-4 margin_top subcat" >
                              <?php echo $imConf->getImage($name='categoria',$index=4, $categoria_id=$model->id);?>
                              <span class="imgNumber  small">4</span>
                    </div>
                    <div onclick="js:modal(5,false);" class="col-md-4 col-sm-4 col-xs-4 margin_top subcat" >
                              <?php echo $imConf->getImage($name='categoria',$index=5, $categoria_id=$model->id);?>
                              <span class="imgNumber  small">5</span>
                    </div>
                    <div onclick="js:modal(6,false);" class="col-md-4 col-sm-4 col-xs-4 margin_top subcat" >
                              <?php echo $imConf->getImage($name='categoria',$index=6, $categoria_id=$model->id);?>
                              <span class="imgNumber  small">6</span>
                    </div>
                    <div onclick="js:modal(7,false);" class="col-md-4 col-sm-4 col-xs-4 margin_top subcat" >
                              <?php echo $imConf->getImage($name='categoria',$index=7, $categoria_id=$model->id);?>
                              <span class="imgNumber  small">7</span>
                    </div>
                    
                    
                
            </div>
        </div>
    </div>
    
</div>
<div id="toLoad" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; min-height: 600px;">
 
</div>

<script>


function modal(index, confirm){ 
        var group = 1;
        var type= 3;
        var name = 'categoria';
        var category= <?php echo $model->id; ?>;
      $.ajax({ 
                      url: "../formConfImage",
                      type: "post",
                      datatype:'json',
                      data: {
                        categoria_id: category,
                        name:name,
                        index:index,
                        group:group,
                        type:type,
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

  