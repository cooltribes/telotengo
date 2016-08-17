<tr>
    <td><?php echo $data->id; ?></td>
    <td><?php echo date('d/m/Y',strtotime($data->create_at)); ?></td>
    <td><?php echo $data->profile->first_name." ".$data->profile->last_name; ?></td>
    <td><?php echo $data->email; ?></td>
    <td><?php echo $data->invited_by->empresa->razon_social?$data->invited_by->empresa->razon_social:" N/D "; ?></td>

    <td><?php echo $data->invited_by->profile->first_name." ".$data->invited_by->profile->last_name; ?></td>
    <td><?php echo $data->invited_by->email; ?></td>

</tr>

