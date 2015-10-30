<div class="col-md-3 profile-leftBar">
    <?php $this->renderPartial('left_bar',array('model'=>$model)); ?>
</div>
<div class="col-md-9 profile-center">
    <h1>Panel de Control</h1>
    <h3>Ordenes</h3>
    <div class="row-fluid clearfix stats">
        <div class="col-md-1 stat no_left_padding">
            <span class="value">000</span>
            <span class="legend">Valor contado</span>            
        </div>
        <div class="col-md-1 stat no_left_padding">
            <span class="value">000</span>
            <span class="legend">Valor contado</span>            
        </div>
        <div class="col-md-1 stat no_left_padding">
            <span class="value">000</span>
            <span class="legend">Valor contado</span>            
        </div>
        <div class="col-md-1 stat no_left_padding">
            <span class="value">000</span>
            <span class="legend">Valor contado</span>            
        </div>
        <div class="col-md-1 stat no_left_padding">
            <span class="value">000</span>
            <span class="legend">Valor contado</span>            
        </div>
        <div class="col-md-1 stat no_left_padding">
            <span class="value">000</span>
            <span class="legend">Valor contado</span>            
        </div>
    </div>
   <div class="row-fluid clearfix cards margin_top">
       <div class="col-md-6 no_padding_left">
          <div class="card row-fluid clearfix">
             <span class="title col-md-7">Info Empresa</span>
             <span class="col-md-5 text-right">
                 <a class="showInfo"  onclick="showInfo('#info1')" id="info1-show">Mostrar Información</a> 
             </span>
             <p class="hide col-md-12" id="info1">
                 Linea 1<br/>
                 Linea 2<br/>
                 Linea 3<br/>
                 Linea 4<br/>
                 
             </p>
          </div> 
       </div>
       <div class="col-md-6 no_padding_left">
          <div class="card row-fluid clearfix">
             <span class="title col-md-7">Almacenes</span>
             <span class="col-md-5 text-right">
                 <a class="showInfo" onclick="showInfo('#info2')" id="info2-show">Mostrar Información</a>
             </span>
             <p class="hide col-md-12" id="info2">
                 Linea 1<br/>
                 Linea 2<br/>
                 Linea 3<br/>
                 Linea 4<br/>
             </p>
             
          </div> 
       </div>
   </div>
    <h3>Ultimas Acciones</h3>
    <table class="table table-striped" width="100%">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>00/00/0000</td>
                <td>Acción realizada en un día determinado llevando a cabo un evento pautado</td>
            </tr>
            <tr>
                <td>00/00/0000</td>
                <td>Acción realizada en un día determinado llevando a cabo un evento pautado</td>
            </tr>
            <tr>
                <td>00/00/0000</td>
                <td>Acción realizada en un día determinado llevando a cabo un evento pautado</td>
            </tr>
            <tr>
                <td>00/00/0000</td>
                <td>Acción realizada en un día determinado llevando a cabo un evento pautado</td>
            </tr>
            <tr>
                <td>00/00/0000</td>
                <td>Acción realizada en un día determinado llevando a cabo un evento pautado</td>
            </tr>
            <tr>
                <td>00/00/0000</td>
                <td>Acción realizada en un día determinado llevando a cabo un evento pautado</td>
            </tr>
        </tbody>
        
    </table>
    
</div>
<script>
    
    function showInfo(id){
        if($(id).hasClass('hide')){
            $(id).removeClass('hide');
            $(id+'-show').html('Ocultar Información');           
        }            
        else{
            $(id).addClass('hide');
            $(id+'-show').html('Mostrar Información');
        }
            
    }
</script>