<?php
    if (isset($this->data['route'])) {
        $route = $this->data['route'];
    }
?>
<tr class="<?php echo @$route->is_hidden; ?>" id="<?php if (!isset($route->temporary)) {
            echo 'parent_row_'.$route->id;
        } else {
            if ($route->temporary == 'temporary_row') {
                $row_id = $route->temporary;
                echo $row_id;
            }
            else {
                $row_id = 'parent_row_'.$route->temporary;
                echo $row_id;
            }
        } ?>">

    <td class="align-center">

        <input type="checkbox" value="" class="action uniform"/>

    </td>

    <td>

        <input class="row_id uniform" type="hidden" name="<?php
            if (!isset($route->temporary) || $route->temporary != 'temporary_row') {
                echo "router[".@$route->id."][row_id]";
            }
            else {
                echo "";
            }
        ?>" value="<?php echo @$route->id; ?>">

    	<input class="id_store uniform" type="hidden" name="<?php
            if (!isset($route->temporary) || $route->temporary != 'temporary_row') {
                echo "router[".@$route->id."][id]";
            }
            else {
                echo "";
            }
        ?>" value="<?php echo @$route->id; ?>">
        <?php
            if (@$route->temporary != 'temporary_row') {
               $select = "router[".@$route->id."][router_source]";
            }
            else {
                $select = "";
            }
        ?>
        <?php if (isset($methods)) {
            $options = (array)$methods;
            $first_opt = array_shift($options);
        } ?>
    	<?php echo form_dropdown($select, (array)$methods, @$route->router_source, 'class="input-long router-select uniform" data-reset="'.@$route->router_source.'"'); ?>

    </td>

    <td>

        <input type="<?php if (isset($route->temporary) && $route->temporary == 'temporary_row') {
            echo 'hidden';
        }else{
            echo "text";
        } ?>" id="" name="<?php
            if (!isset($route->temporary) || $route->temporary != 'temporary_row') {
                echo "router[".@$route->id."][router_key]";
            }
            else {
                echo "";
            }
        ?>" data-old="" class="input-long router-key uniform" value="<?php if (isset($route->router_key)) {
            echo @$route->router_key;
        }
        else {
            echo @$first_opt;
        } ?>" data-reset="<?php echo @$route->router_key; ?>" title="">

    </td>

    <td>

    	<input type="<?php if (isset($route->temporary) && $route->temporary == 'temporary_row') {
            echo 'hidden';
        }else{
            echo "text";
        } ?>" id="" name="<?php
            if (!isset($route->temporary) || $route->temporary != 'temporary_row') {
                echo "router[".@$route->id."][router_value]";
            }
            else {
                echo "";
            }
        ?>" data-old="" class="input-long router-value uniform" value="<?php echo @$route->router_value; ?>" data-reset="<?php echo @$route->router_value; ?>" required="required" title="">

    </td>

    <td>

        <?php

            $dataAction = array(
                'preview' => array(
                    'class' => 'preview',
                    'href' => site_url(@$route->router_value),
                    'target' => '_blank',
                    'title' => ''
                )
            );

            if ((isset($route->allow_delete) && $route['allow_delete']) || $this->ion_auth->is_admin()) {

                $dataAction['delete'] = array(
                    'class' => 'delete_action',
                    'href' => site_url('routers/delete').'/'.base64_encode($route->id),
                    'target' => '',
                    'title' => '',
                    'data-original-title' => '',
                    'data-target' => array(
                        'target' => '',
                        'control' => 'routers',
                        'file' => base64_encode($route->id)
                    ),
                    'data-toggle' => 'confirmation',
                    'style' => 'display: inline-block;'
                );
                
            }

            $data['table_action'] = $dataAction;

            echo $this->load->common("table/table_action", true, $data);

        ?>

    </td>

</tr>