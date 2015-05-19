<div class="container">
	<div class="row-fluid">
		<h1>Forma parte de Telotengo.com</h1>
        <hr class="no_margin_top"/>
		<div class="col-sm-12">				
            <div class="margin_top margin_bottom alert in alert-block fade alert-info text_align_center"> 
                 <?php echo $user->email; ?>, encontramos tu correo electrónico en nuestra base de datos ya que el día
                 <?php echo date('l d',strtotime($user->create_at)); ?> de <?php echo date('F',strtotime($user->create_at)); ?> del
                 <?php echo date('Y',strtotime($user->create_at)); ?> hiciste una solicitud de invitación.<br/>
                 Pedimos disculpas por no haber podido atender a dicha solicitud aún y esperamos hacerlo prontamente.<br/><br/>
                 Dado que realizamos un proceso de validación robusto y manual para garantizar la veracidad de todos los integrantes,
                 hemos acumulado mucho trabajo y una lista en espera que seguimos actualizando. Una vez lleguemos a tu caso,
                 te contactaremos y invitaremos a participar. 
            </div>
            <div class="margin_top margin_bottom">
                <div>
                    <a href="http://telotengo.com/new"><button type="button" class="btn btn-success">Ir al inicio</button></a>
                </div>
            </div>
        </div>
    </div>
</div>