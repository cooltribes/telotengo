<tr>	 
	<td><?php echo $data->id; ?></td>
	<td><?php echo $data->inicio_vigencia; ?></td>
	<td><?php echo $data->fin_vigencia; ?></td>
	<td><?php echo $data->monto; ?></td>
	<td><?php $user = User::model()->findByPk($data->comprador); echo $user->email; ?></td>
	<td><?php echo $data->beneficiario; ?></td>
	<td>Estado</td>
	<td>Accion</td>
</tr>