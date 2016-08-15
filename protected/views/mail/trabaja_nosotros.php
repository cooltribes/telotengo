El usuario <?php echo $model->nombre; ?>, ha enviado sus datos y su Currículum Vitae porque desea trabajar con nosotros en Telotengo. <br><br>

Nombre: <?php echo $model->nombre; ?><br>
Sexo: <?php if($model->sexo==1)echo "Masculino";else echo "Femenino"; ?><br>
Lugar de nacimiento: <?php echo $model->lugar_nacimiento; ?><br>
Fecha de nacimiento: <?php $var=explode(" ",Funciones::invertirFecha($model->fecha_nacimiento)); echo $var[0]; ?><br>
Dirección: <?php echo $model->direccion;?><br>
Email: <?php echo $model->email;?><br><br>

Adjunto se encuentra el CV.
