<?php for($i=0; $i<3; $i++): ?>
<div class="orderContainer margin_top_small margin_bottom">
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
                            <?php for($j=0; $j<5; $j++): ?>
                                <tr>
                                <td class="img"><img src="http://placehold.it/80x80"/></td>
                                <td class="name">MOUSE MICROSOFT OPTICAL</td>
                                <td class="number"><input type="number"></td>
                                <td class="number">500 Bs</td>
                                <td class="number highlighted">50,000 Bs</td>
                                <td class="link"><a href="#">Eliminar</a></td>
                                
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <div class="summary text-right">
                    <span>Total: Bs. 420.000</span>
                    <input class="btn-orange btn btn-danger btn-large orange_border margin_left" type="submit" name="yt0" value="Generar orden por proveedor">
                </div>
            </div>
 <?php endfor;  ?>
