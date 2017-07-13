<?php

echo '<div class="table-tool">';

if (isset($table_action['update']) && count($table_action['update']) > 0) {

	$tagHTML = '<a title="'.lang('Update').'"';
	
	foreach ($table_action['update'] as $keyUpdate => $valueUpdate) {

		if (is_null($valueUpdate) || $valueUpdate == '') {
			
			continue;

		}

		if (is_array($valueUpdate)) {
			
			$valueUpdate = json_encode($valueUpdate);

			$tagHTML .= " " . $keyUpdate . "='" . $valueUpdate . "'";

		} else {
		
			$tagHTML .= ' ' . $keyUpdate . '="' . $valueUpdate . '"';

		}
		
	}

	$tagHTML .= '>';

	echo $tagHTML;

	echo '<span class="glyphicon glyphicon-pencil"></span>';

	echo '</a>';

}

if (isset($table_action['preview']) && count($table_action['preview']) > 0) {

	$tagHTML = '<a target="_blank" title="'.lang('Preview').'"';
	
	foreach ($table_action['preview'] as $keyPreview => $valuePreview) {

		if (is_null($valuePreview) || $valuePreview == '') {
			
			continue;

		}

		if (is_array($valuePreview)) {
			
			$valuePreview = json_encode($valuePreview);

			$tagHTML .= " " . $keyPreview . "='" . $valuePreview . "'";

		} else {
		
			$tagHTML .= ' ' . $keyPreview . '="' . $valuePreview . '"';

		}
		
	}

	$tagHTML .= '>';

	echo $tagHTML;

	echo '<span class="glyphicon glyphicon-eye-open"></span>';

	echo '</a>';

}

if (isset($table_action['export']) && count($table_action['export']) > 0) {

	$tagHTML = '<a title="'.lang('Export').'"';
	
	foreach ($table_action['export'] as $keyExport => $valueExport) {

		if (is_null($valueExport) || $valueExport == '') {
			
			continue;

		}

		if (is_array($valueExport)) {
			
			$valueExport = json_encode($valueExport);

			$tagHTML .= " " . $keyExport . "='" . $valueExport . "'";

		} else {
		
			$tagHTML .= ' ' . $keyExport . '="' . $valueExport . '"';

		}
		
	}

	$tagHTML .= '>';

	echo $tagHTML;

	echo '<span class="glyphicon glyphicon-export"></span>';

	echo '</a>';

}

if (isset($table_action['compare']) && count($table_action['compare']) > 0) {

	$tagHTML = '<a title="'.lang('Compare').'"';
	
	foreach ($table_action['compare'] as $keyExport => $valueExport) {

		if (is_null($valueExport) || $valueExport == '') {
			
			continue;

		}

		if (is_array($valueExport)) {
			
			$valueExport = json_encode($valueExport);

			$tagHTML .= " " . $keyExport . "='" . $valueExport . "'";

		} else {
		
			$tagHTML .= ' ' . $keyExport . '="' . $valueExport . '"';

		}
		
	}

	$tagHTML .= '>';

	echo $tagHTML;

	echo '<img src="'.base_url(TEMPLATE_PATH.@$template).'/img/compare-64.png"width="16" height="16" alt="'.lang('Compare').'" />';

	echo '</a>';

}

if (isset($table_action['delete']) && count($table_action['delete']) > 0) {

	$tagHTML = '<a title="'.lang('Export').'"';
	
	foreach ($table_action['delete'] as $keyDelete => $valueDelete) {

		if (is_null($valueDelete) || $valueDelete == '') {
			
			continue;

		}

		if (is_array($valueDelete)) {
			
			$valueDelete = json_encode($valueDelete);

			$tagHTML .= " " . $keyDelete . "='" . $valueDelete . "'";

		} else {
		
			$tagHTML .= ' ' . $keyDelete . '="' . $valueDelete . '"';

		}
		
	}

	$tagHTML .= '>';

	echo $tagHTML;

	echo '<span class="glyphicon glyphicon-trash"></span>';

	echo '</a>';

}

echo "</div>";

?>