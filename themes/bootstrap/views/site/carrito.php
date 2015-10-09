<style>
.orderContainer>div{
    padding: 10px 5%;
}
.orderContainer .title{
    border: solid 1px #666;
    font-size:21px;
}
.orderContainer .detail{
    border-left: solid 1px #666;
    border-right: solid 1px #666;
}
.orderContainer .detail table{
    font-size: 12px;
    color: #222;
}
.orderContainer .detail table tbody td.name{
    font-weight: 900;
    padding: 0px 10px;
}
.orderContainer .detail table tbody td.link a{
    color: #888;
    font-weight: 900;
}
.orderContainer .summary span{
    font-size:20px;
    font-weight: bolder;
}
.orderContainer .detail table tbody td.number input{
    width:80%;
}
.orderContainer .detail table tbody td.number.highlighted{
    color: #ec1f24;
}
.orderContainer .detail table tbody td.number, .orderContainer .detail table tbody td.img{
    text-align:center; 
    font-weight: bolder;
}

.orderContainer .summary{ 
    border: solid 1px #666;
} 

.orderAll{
    background: #DDD;
    text-align: center;
    padding: 35px 0px 30px 0px;
    font-size: 12px;
    font-weight: 900;
}
.orderAll .total{
    font-size: 20px;
    font-weight: bolder;
    display: inline-block;
    margin-top: 1.5em;
    
}
.orderAll .btn{
    padding-left: 10%;
    padding-right: 10%;
    font-weight: bolder;
}

.btn-green{
    background: #00A000;
    border-radius: 0px;
    border-color: transparent;
}

.btn-green:hover, .btn-green:focus{
    background: #00AA00;
    border-color: transparent;

.mutedLink>a, .mutedLink>a:hover, .mutedLink>a:focus{
    color: #CCC;
    font-size: 11px;
    text-decoration: none;
}

}

	.button_click { color: black; font-weight:bolder;}
	

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
			        	
						location.reload();
			       	}
			    })
		});
	});	
</script>



