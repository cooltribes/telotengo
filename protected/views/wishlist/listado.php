<?php
$this->breadcrumbs=array(
	'Listas de deseos',
);

?>
<div class="container">
    <div class="row-fluid">
        <h1 class="col-md-10">Mis listas de deseos</h1>
        <div class="col-md-2 margin_top_medium">
            <?php
                echo CHtml::link('<i class="glyphicon glyphicon-plus"></i> Nueva lista', $this->createUrl('create'), array('class'=>'btn btn-success', 'role'=>'button'));
            ?>
        </div>
    </div>
	

		<hr class="no_margin_top" />

		<?php if(Yii::app()->user->hasFlash('success')){?>
		    <div class="alert in alert-block fade alert-success text_align_center">
		        <?php echo Yii::app()->user->getFlash('success'); ?>
		    </div>
		<?php } ?>
		<?php if(Yii::app()->user->hasFlash('error')){?>
		    <div class="alert in alert-block fade alert-danger text_align_center">
		        <?php echo Yii::app()->user->getFlash('error'); ?>
		    </div>
		<?php } ?>

	  
	<?php
	$template = '{summary}
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
	        <tr>
	            <th scope="col">Nombre</th>
	            <th scope="col">Fecha de creación</th>
	            <th scope="col">Productos</th>
				<th scope="col">Acción</th>
	        </tr>
	    {items}
	    </table>
	    {pager} 
		';

			$this->widget('zii.widgets.CListView', array(
		    'id'=>'list-auth-wishlist',
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'_datos_listado',
		    'template'=>$template,
		    'enableSorting'=>'true',
		    'afterAjaxUpdate'=>" function(id, data) {
							   
								} ",
			'pager'=>array(
				'header'=>'',
				'htmlOptions'=>array(
				'class'=>'pagination pagination-right',
			)
			),					
		));  
		
		?>

	<?php
		echo CHtml::hiddenField("id_wishlist",0);
	?>

    <div id="wishlistName" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;">
    </div>	

</div>

<script type="text/javascript"> 
	function activarModal(id){

		$('#id_wishlist').val(id);

		 $.ajax({ 
                url: "<?php echo Yii::app()->createUrl('wishlist/cambiarnombre'); ?>",
                type: "post",
                data: { id: id},
                success: function(data){
                	$("#wishlistName").html(data);
                    $("#wishlistName").modal();
    			},
            });
	}
</script>