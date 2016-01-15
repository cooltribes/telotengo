<tr>
    <td><?php echo $data->id; ?></td>
    <td><?php echo $data->profile->first_name." ".$data->profile->last_name; ?></td>
    <td><?php echo $data->email; ?></td>
    <td><?php echo $data->empresa->razon_social?$data->empresa->razon_social:" N/D "; ?></td>
    <td><?php echo $data->invited_by->email; ?></td>

</tr>

