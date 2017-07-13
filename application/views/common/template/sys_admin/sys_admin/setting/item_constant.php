<tr class="item_constant <?php echo "item_constant_$id"; ?>">

	<td class="align-center">

        <input type="checkbox" value="" class="action uniform"/>

    </td>

    <td class="col-md-5 constant_key" data-constant="<?php echo $constant; ?>"><?php echo $constant; ?></td>

    <td class="col-md-5 constant_value" data-constant="<?php echo $value; ?>"><?php echo $value; ?></td>

    <td class="col-md-2 action">

    	<?php

    	$dataAction = array(
    		'update' => array(
				'class' => 'update_action',
				'href' => 'javascript:void(0);',
				'target' => '',
				'title' => '',
				'data-original-title' => '',
				'data-target' => '',
				'data-toggle' => '',
				'style' => 'display: inline-block;',
				'data-update' => base64_encode($id)
			),
			'delete' => array(
				'class' => 'delete_action',
				'href' => site_url('my_constants/delete').SLASH.base64_encode($id),
				'target' => '',
				'title' => '',
				'data-original-title' => '',
				'data-target' => array(
					'target' => base64_encode($id),
					'control' => 'my_constants',
					'file' => base64_encode($id)
				),
				'data-toggle' => 'confirmation',
				'style' => 'display: inline-block;'
			)
		);

		$data['table_action'] = $dataAction;

    	echo $this->load->common("table/table_action", true, $data);

    	?>

    </td>

</tr>