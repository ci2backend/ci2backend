<a class="dashboard-module" href="<?php
	if (strpos($menu['action'], '.html') >= 0) {
		echo base_url($menu['action']);
	}
	else{
		echo site_url($menu['action']);
	}
?>" title="<?php echo $menu['description']; ?>">
                            
    <img alt="edit" src="<?php echo base_url(TEMPLATE_PATH.@$template);?>/img/<?php echo $menu['icon']; ?>">
    
    <span><?php echo $this->lang->line($menu['title_key']); ?></span>

</a>