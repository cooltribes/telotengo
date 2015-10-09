<style>
    .orderInfo{
        font-size: 16px;
    }
    #orderDetail h2{
        font-size: 18px;
        font-weight: bolder;
        margin: 0;
    }
    #orderDetail div h3{        
        margin: 0;
        font-size: 16px;
    }
    .orderInfo .estadoOrden span{        
        font-size:24px;
        font-weight: bold;
    }
    .orderInfo .estadoOrden span.success{
        color: #08CB53;
    }
    .orderInfo .estadoOrden span.warning{
        color: #ffe45c;
    }
    .orderInfo .estadoOrden span.error{
        color: #a94442;
    }
    .orderInfo .sellerInfo p{
        margin:1px 0px;              
    }
    .orderInfo .sellerInfo p span.name{
        font-weight: bold;             
    }
    .orderActions table{
        margin-top:5px;
        font-size: 16px;
        font-weight:500;
    }
    .orderActions table > thead > tr > th{
        background-color: #222;
        font-weight: 500;
        color: #FFF;
    }
    .orderActions .table-striped > tbody > tr > td{
        background-color: #eee;
    }
    .orderActions .table-striped > tbody > tr:nth-child(odd) > td{
        background-color: #f9f9f9;
    }
    .orderActions table td, .orderActions table th{
        padding: 5px 0px 5px 8px;
    }
    
</style>
<div id="orderDetail" class="row-fluid">
    <h2>ORDEN DE COMPRA</h2>
    <div class="col-md-7 orderInfo no_horizontal_padding">
        
        <h3 class="margin_top_small">Estado actual:</h3>
        <p class="estadoOrden"><span class="success">Finalizada</span></p>
        <div class="margin_top sellerInfo">
            <p>
                <span class="name">Información del Vendedor</span>
            </p>
            <p>
                <span class="name">N° de Orden:</span>
                <span class="value">123456</span>
            </p>
            <p>
                <span class="name">Fecha de Emisión:</span>
                <span class="value">21/02/2015</span>
            </p>
            <p>
                <span class="name">Proveedor:</span>
                <span class="value">SIGMATIENDAS C.A.</span>
            </p>
            <p>
                <span class="name">RIF:</span>
                <span class="value">J-12345678-9</span>
            </p>
            <p>
                <span class="name">Dirección de Envío:</span>
                <span class="value">Edif. Los Mirtos, Piso 3 Oficina 3 San Cristóbal Edo. Táchira</span>
            </p>
            <p>
                <span class="name">Teléfono:</span>
                <span class="value">0276 3556625</span>
            </p>
            <p>
                <span class="name">Correo Electrónico:</span>
                <span class="value">sigmatiendas@sigma.com</span>
            </p>
        </div>
    </div>
    <div class="col-md-5 orderActions no_horizontal_padding">
        <h3>Acciones pendientes</h3>
        <table width="100%" class="table-striped">
            <col width="30%">
            <col width="40%">
            <col width="30%">
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Aprobado</td>
                    <td>Admin</td>
                    <td>21/10/2015</td>
                </tr>
                <tr>
                    <td>Aprobado</td>
                    <td>Admin</td>
                    <td>21/10/2015</td>
                </tr>
                <tr>
                    <td>Aprobado</td>
                    <td>Admin</td>
                    <td>21/10/2015</td>
                </tr>
                <tr>
                    <td>Aprobado</td>
                    <td>Admin</td>
                    <td>21/10/2015</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="col-md-12 cart no_horizontal_padding">
        <div class="orderContainer margin_top_large margin_bottom">
                <div class="title clearfix">
                   <div class="row-fluid">
                      <div class="col-md-6 no_horizontal_padding">ORDEN #123456</div>
                       <div class="col-md-6 no_horizontal_padding text-right">Vendido por: Montilla's Company</div>
                   </div>
                </div>
                <div class="detail">
                    <table width="100%">
                        <colgroup>
                        <col width="10%">
                        <col width="30%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        </colgroup><thead>
                            <tr>
                                <th colspan="2">Producto</th>
                                <th class="text-center"># de Item</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Precio Unt.</th>
                                <th class="text-center">Sub Total</th>
                                 <th class="text-center">I. V. A.</th>
                                  <th class="text-center">Precio Total</th>
                               
                            </tr>
                        </thead>
                        
                        <tbody>
                             <tr>
                                <td class="img"><img width="100%" src="http://telotengo.com/new/images/producto/1509/159.jpg"></td>
                                <td class="name"> Samsung Galaxy S5, Black 16GB (Verizon Wireless)</td>
                                <td class="number">7620451</td>
                                <td class="number">100</td>
                                <td class="number">550 Bs</td>
                                <td class="number highlighted">550000 Bs</td>
                                <td class="number highlighted">550000 Bs</td>
                                <td class="number highlighted"> 1650000 Bs</td>
                                
                                
                            </tr>
                            <tr>
                                <td class="img"><img width="100%" src="http://telotengo.com/new/images/producto/1509/159.jpg"></td>
                                <td class="name"> Samsung Galaxy S5, Black 16GB (Verizon Wireless)</td>
                                <td class="number">7620451</td>
                                <td class="number">100</td>
                                <td class="number">550 Bs</td>
                                <td class="number highlighted">550000 Bs</td>
                                <td class="number highlighted">550000 Bs</td>
                                <td class="number highlighted"> 1650000 Bs</td>
                                
                                
                            </tr>
                            <tr>
                                <td class="img"><img width="100%" src="http://telotengo.com/new/images/producto/1509/159.jpg"></td>
                                <td class="name"> Samsung Galaxy S5, Black 16GB (Verizon Wireless)</td>
                                <td class="number">7620451</td>
                                <td class="number">100</td>
                                <td class="number">550 Bs</td>
                                <td class="number highlighted">550000 Bs</td>
                                <td class="number highlighted">550000 Bs</td>
                                <td class="number highlighted"> 1650000 Bs</td>
                                
                                
                            </tr>
                       </tbody>
                    </table>
                </div>
               

                <div class="summary text-right">
                    
                    <span id="total">Total: Bs. 1650000</span>
                   
                </div>
            </div>
    </div>
    
    
    
</div>

