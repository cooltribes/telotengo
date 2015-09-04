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
    padding-left: 30px;
    padding-right: 30px;
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
</style>
<div class="col-md-12">
    <h1 class="dark no_margin">ORDENES DE COMPRA</h1>
</div>
<div class="col-md-12 no_horizontal_padding cart">
    <div class="row-fluid">
        <div class="col-md-9">
            <?php $this->renderPartial('orders',array('orders'=>NULL)); ?>
        </div>        
        <div class="col-md-3">
            <div class="orderAll margin_top_small">
                Subtotal: Bs. 1,330.000 <br/>
                IVA: Bs. 200.000 <br/>
                <span class="total">
                    Total: Bs. 1,530.000
                </span>
                <input class="btn-green btn btn-danger btn-large margin_top_small" type="submit" name="yt0" value="Procesar todas las órdenes">
            </div>
            <div class="text-center mutedLink">
                <a href="#">Ver políticas de envíos y devoluciones</a>
            </div>
            
        </div>
        
    </div>
</div>



