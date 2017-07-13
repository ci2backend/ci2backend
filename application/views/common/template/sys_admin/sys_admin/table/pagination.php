<?php
    if (isset($this->CI->data['ext_loaded']['tablesorter'])) {
?>
        <div class="pager" id="pager">

            <form action="javascript:void(0);">

                <div>

                    <img class="first" src="<?php echo base_url(TEMPLATE_PATH.@$template);?>/img/arrow-stop-180.gif" alt="first"/>

                    <img class="prev" src="<?php echo base_url(TEMPLATE_PATH.@$template);?>/img/arrow-180.gif" alt="prev"/> 

                    <input type="text" class="pagedisplay uniform input-short align-center"/>

                    <img class="next" src="<?php echo base_url(TEMPLATE_PATH.@$template);?>/img/arrow.gif" alt="next"/>

                    <img class="last" src="<?php echo base_url(TEMPLATE_PATH.@$template);?>/img/arrow-stop.gif" alt="last"/> 

                    <select class="pagesize input-short align-center uniform">

                        <option value="10" selected="selected">10</option>

                        <option value="20">20</option>

                        <option value="30">30</option>

                        <option value="40">40</option>

                        <option value="all">All Rows</option>

                    </select>

                </div>

            </form>

        </div>
<?php
    }
?>