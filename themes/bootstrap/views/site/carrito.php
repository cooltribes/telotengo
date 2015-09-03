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
}
.orderContainer .detail table tbody td.name{
    font-weight: 900;
    padding: 0px 10px;
}
.orderContainer .detail table tbody td.link a{
    color: #888;
    font-weight: 900;
}
.orderContainer .detail table tbody td.number input{
    width:80%;
}
.orderContainer .detail table tbody td.number, .orderContainer .detail table tbody td.img{
    text-align:center; 
}

.orderContainer .summary{
    border: solid 1px #666;
} 

</style>
<div class="col-md-12">
    <h1 class="dark no_margin">ORDENES DE COMPRA</h1>
</div>
<div class="col-md-12 no_horizontal_padding cart">
    <div class="row-fluid">
        <div class="col-md-9">
            <div class="orderContainer margin_top_small margin_bottom_small">
                <div class="title clearfix">
                   <div class="row-fluid">
                       <div class="col-md-6 no_horizontal_padding">ORDEN #123456</div>
                       <div class="col-md-6 no_horizontal_padding text-right">Vendido por: Sigmatiendas C. A.</div>
                   </div>
                </div>
                <div class="detail">
                    <table width="100%">
                        <col width="10%">
                        <col width="42%">
                        <col width="12%">
                        <col width="12%">
                        <col width="12%">
                        <col width="12%">
                        <thead>
                            <tr>
                                <th colspan="2">Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Precio Unt.</th>
                                <th class="text-center">Sub Total</th>
                                <th class="text-center"></th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="img"><img src="http://placehold.it/80x80"/></td>
                                <td class="name">MOUSE MICROSOFT OPTICAL</td>
                                <td class="number"><input type="number"></td>
                                <td class="number">500 Bs</td>
                                <td class="number">50,000 Bs</td>
                                <td class="link"><a href="#">Eliminar</a></td>
                                
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="summary">
                    RESUMEN
                </div>
            </div>
        </div>        
        <div class="col-md-3"></div>
        
    </div>
</div>



