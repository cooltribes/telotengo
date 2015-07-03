<style>
.v-center {
  min-height:200px;
  display: flex;
  justify-content:center;
  flex-flow: column wrap;
}	
	
	
</style>


<?php $categoria=69;//////SUPONGAMOS QUE RECIBIMOS UN ID POR POST O POR GET..... LE VOY ASIGNAR 
$model=Categoria::model()->findByPk($categoria);
?>

<div class="container">
  <div class="row">
        <div class="col-md-12 text-center"><h3>Atributo con Categoria</h3></div>
  		<div class="col-sm-4 col-sm-offset-1">
          <div class="list-group" id="list1">
          <a href="#" class="list-group-item active">Todos los Atributos <input title="toggle all" type="checkbox" class="all pull-right"></a>
          <?php    
		  $atributos=Atributo::model()->findAllBySql("SELECT * FROM tbl_atributo where id not in
		  (select atributo_id from tbl_categoria_atributo where activo=1 and categoria_id =".$model->id.")");
          foreach($atributos as $atr)
          {?>
          	   <a href="#"  id=<?php echo $atr->id;?> class="list-group-item"><?php echo $atr->nombre;?><input type="checkbox" class="pull-right"></a>
          <?php
		  } ?>
          </div>
        </div>
        <div class="col-md-2 v-center">
     		<button title="Send to list 2" class="btn btn-default center-block add"><i class="glyphicon glyphicon-chevron-right"></i></button>
            <button title="Send to list 1" class="btn btn-default center-block remove"><i class="glyphicon glyphicon-chevron-left"></i></button>
        </div>
        <div class="col-sm-4">
    	  <div class="list-group" id="list2">
          <a href="#" class="list-group-item active">Atributos de <?php echo $model->nombre;?><input title="toggle all" type="checkbox" class="all pull-right"></a>
          <?php    
		  $atributos=Atributo::model()->findAllBySql("SELECT * FROM tbl_atributo where id in
		  (select atributo_id from tbl_categoria_atributo where activo=1 and categoria_id =".$model->id.")");
          foreach($atributos as $atr)
          {?>
          	   <a href="#"  id=<?php echo $atr->id;?> class="list-group-item"><?php echo $atr->nombre;?><input type="checkbox" class="pull-right"></a>
          <?php
		  } ?>
          </div>
        </div>
  </div>
  
  	<div id="avanzar" class="col-md-6 col-md-offset-3 margin_top">
			<a class="btn btn-danger form-control"  title="Guardar">Guardar</a>
	</div>
</div>


<script>

$('.add').click(function(){
    $('.all').prop("checked",false);
    var items = $("#list1 input:checked:not('.all')");
    var n = items.length;
  	if (n > 0) {
      items.each(function(idx,item){
        var choice = $(item);
        choice.prop("checked",false);
        choice.parent().appendTo("#list2");
              choice.addClass( "selected" );
      });
  	}
    else {
  		alert("Eliga un Atributo");
    }
});

$('.remove').click(function(){
    $('.all').prop("checked",false);
    var items = $("#list2 input:checked:not('.all')");
	items.each(function(idx,item){
      var choice = $(item);
      choice.prop("checked",false);
      choice.parent().appendTo("#list1");
    });
});

/* toggle all checkboxes in group */
$('.all').click(function(e){
	e.stopPropagation();
	var $this = $(this);
    if($this.is(":checked")) {
    	$this.parents('.list-group').find("[type=checkbox]").prop("checked",true);
    }
    else {
    	$this.parents('.list-group').find("[type=checkbox]").prop("checked",false);
        $this.prop("checked",false);
    }
});

$('[type=checkbox]').click(function(e){
  e.stopPropagation();
});

/* toggle checkbox when list group item is clicked */
$('.list-group a').click(function(e){
  
    e.stopPropagation();
  
  	var $this = $(this).find("[type=checkbox]");
    if($this.is(":checked")) {
    	$this.prop("checked",false);
    }
    else {
    	$this.prop("checked",true);
    }
  
    if ($this.hasClass("all")) {
    	$this.trigger('click');
    }
});	


	$('#avanzar').on('click', function(event) {
		var j=0;
		var vector= [];
		var idAct= <?php echo $model->id;?>;
		$("#list2 a").each(function (index) 
        { 
           if(j!=0)
           {
           	   vector.push($(this).attr('id'));
           	  // alert($(this).attr('id'));
           }
           j++;

           
        }) 
        
        if(j==1)
        {
        	alert('seleccione un atributo');
        	return false;
        }
        else
        {
        		$.ajax({
		         url: "<?php echo Yii::app()->createUrl('Categoria/catAtrib') ?>",
	             type: 'POST',
		         data:{
	                    idAct:idAct, vector:vector,
	                   },
		        success: function (data) {
					
					window.location.href = '../categoria/admin/';
		       	}
		       })
        }
		
	});
	
</script>