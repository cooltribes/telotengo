<style>

</style>
<div class="col-md-12">
    <h1 class="dark no_margin">INTENCION DE COMPRA</h1>
</div>
<div class="col-md-12 no_horizontal_padding cart">
    <div class="row-fluid">
        <div class="col-md-9">
            <?php $this->renderPartial('orders',array('orders'=>NULL,'model'=>$model, 'bolsaInventario'=>$bolsaInventario)); ?>
        </div>        
        <div class="col-md-3">
            <div class="orderAll margin_top_small">
                Subtotal: Bs. <?php echo $sub=Yii::app()->session['suma'];?><br/>
                IVA: Bs. <?php echo $iva=Yii::app()->session['suma']*0.12;?> <br/>
                <span class="total">
                    Total: Bs. <?php echo Yii::app()->session['suma']+$iva;  unset(Yii::app()->session['suma']);?>
                </span>
                <input class="btn-green btn btn-danger btn-large margin_top_small" type="submit" id="procesarTodo" name="yt0" value="Procesar todas las órdenes">
            </div>
            <div class="text-center mutedLink">
                <a class="muted" href="#">Ver políticas de envíos y devoluciones</a>
            </div>
            
        </div>
        
    </div>
</div>
 

<script>
	$(document).ready(function() {
		$('#procesarTodo').click(function() {
			var bolsa_id= '<?php echo $model->id;?>';
			var empresas_id='<?php echo $model->empresas_id;?>';
			var monto= <?php echo $sub;?>;
			var iva= <?php echo $iva?>;
			
						$.ajax({
			         url: "<?php echo Yii::app()->createUrl('Orden/procesarTodo') ?>",
		             type: 'POST',
			         data:{
		                    bolsa_id:bolsa_id, empresas_id:empresas_id, monto:monto, iva:iva
		                   },
			        success: function (data) {
			        	
						var path= "<?php echo Yii::app()->createUrl('Orden/misCompras') ?>";
						window.location.href = path;
			       	}
			    })
		});
	});	
</script>



