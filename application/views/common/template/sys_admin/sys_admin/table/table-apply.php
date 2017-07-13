<div class="table-apply grid_6 grid">

    <form action="javascript:void(0);" target-id="myTable">

        <div>

        <span><?php echo lang('Apply_action_to_selected'); ?>:</span> 

        <select class="input-medium uniform" id="table-group-action">

            <option value="0" selected="selected"><?php echo lang('Select_action'); ?></option>

            <option value="selectAll" data-confirmation="0"><?php echo lang('Select_all'); ?></option>

            <option value="deselectAll" data-confirmation="0"><?php echo lang('Deselect_all'); ?></option>

            <option value="delete_action" data-confirmation="1"><?php echo lang('Delete_selected_item'); ?></option>

        </select>

        </div>

    </form>

</div>
