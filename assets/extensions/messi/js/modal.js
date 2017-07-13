function modalSelect(fun_Y, label_btn, id_bnt_Y, content, title) {
    new Messi(content, {
        title: title,
        buttons: [{
            id: id_bnt_Y,
            label: label_btn,
            val: 0,
            'class': 'return'
        }],
        callback: function(val) {
            // callback here
        },
        modal: false,
        closeButton: true
    });
    $('#' + id_bnt_Y).click(function() {
        fun_Y.call(this);
    });
    re_init_point_messi();
}

function modalYN(fun_Y, fun_N, content, title) {
    new Messi(content, {
        title: title,
        buttons: [{
            id: 0,
            label: 'Yes',
            val: 'Y'
        }, {
            id: 1,
            label: 'No',
            val: 'N'
        }],
        callback: function(val) {
            if (val == 'Y') {
                fun_Y.call();
            } else {
                fun_N.call();
            }
        },
        modal: false,
        autoclose: 5000,
        closeButton: true
    });
    return;
}

function modalPopup(fun_Y, fun_N, content, title) {
    new Messi(content, {
        title: title,
        buttons: [{
            id: 0,
            label: 'Yes',
            val: 'Y'
        }, {
            id: 1,
            label: 'No',
            val: 'N'
        }],
        callback: function(val) {
            if (val == 'Y') {
                fun_Y.call();
            } else {
                fun_N.call();
            }
        },
        modal: false,
        autoclose: false,
        closeButton: true
    });
}

function modalPopupManural(afterLoad, idTable, des_id_table, fun_Y, fun_N, content, title, bnt_Y, id_bnt_Y, bnt_N, id_bnt_N) {
    new Messi(content, {
        title: title,
        buttons: [{
            id: id_bnt_Y,
            label: bnt_Y,
            val: 0,
            'class': 'return'
        }, {
            id: id_bnt_N,
            label: bnt_N,
            val: 1
        }],
        callback: function(val) {
            // callback here
        },
        modal: false,
        closeButton: true
    });
    $('#' + id_bnt_Y).click(function() {
        fun_Y.call(this, idTable, des_id_table);
    });
    $('#' + id_bnt_N).click(function() {
        fun_N.call(this, idTable);
    });
    afterLoad.call(this, idTable);
    re_init_point_messi();
}

function modalManural(title, content, Arr_button) {

    var button = [];

    for (var i = 0; i < Arr_button.length; i++) {

        var item = {

            id: Arr_button[i].id,

            label: Arr_button[i].label,

            val: Arr_button[i].val,

            'class': 'return'
        }

        button.push(item);

    };

    button.push({
        id: 'close',
        label: 'Close',
        val: 0

    });

    new Messi(content, {

        title: title,

        buttons: button,

        modal: true,

        closeButton: true

    });

    for (var k = 0; k < Arr_button.length; k++) {

        el = Arr_button[k];

        console.info(el.func);

        bt = document.getElementById(el.id);

        $(bt).bind("click", el.data, el.func, false);

    };


}

function modalMap(fun_N, content, title, bnt_N, id_bnt_N) {
    new Messi(content, {
        title: title,
        buttons: [{
            id: id_bnt_N,
            label: bnt_N,
            val: 1
        }],
        callback: function(val) {
            // callback here
        },
        modal: false,
        closeButton: true
    });
    $('#' + id_bnt_N).click(function() {
        fun_N.call();
    });
    re_init_point_messi_map();
}

/**
 * Close map popup and save data.
 */
function map_dismiss() {
    document.getElementById('address-lat').value = document.getElementById('tmp-address-lat').value;
    document.getElementById('address-lng').value = document.getElementById('tmp-address-lng').value;
    document.getElementById('address-1').value = document.getElementById('new-address').value;
    document.getElementById('city').value = document.getElementById('new-city').value;
    document.getElementById('state').value = document.getElementById('new-state').value;
}

function modalMapWidget(content, title) {
    new Messi(content, {
        title: title,
        callback: function(val) {
            // callback here
        },
        modal: false,
        closeButton: true
    });
    re_init_point_messi_map();
}

function continue_event() {
    // body...
}

function reload() {
    alert('vao day');
}

function add_admin_button() {

    $("#sample_1").next().append('<div class="span4 margin17top"> \
		<a class="btn mini blue" href="javascript:void(0);" id="add-new-admin"> \
          <i class="icon-plus"> \
          </i> \
           Add New Admin \
        </a> \
	</div>');
    $("#add-new-admin").click(function() {
        form_add_listing_admin();
        // modalManural(init_app,'sample_2','sample_1', Yes, No, load_member_list, 'Add Admin', 'Save', 'id_save', 'Cancel', 'id_cancel');
        re_init_point_messi();
    });
}

function re_init_point_messi() {
    var width = ($(document).width() - $('.messi-box').width()) / 2 + 'px';
    var height = ($(window).height() - $('.messi-box').height()) / 2 + 'px';
    var max_height = $(window).height();
    $('.messi').css({
        top: height,
        left: width,
        'max-height': max_height
    });
}

function re_init_point_messi_map() {
    var width = ($(window).width() - $('.messi-box').width()) / 3.5 + 'px';
    var height = ($(window).height() - $('.messi-box').height()) / 3 + 'px';
    var max_height = $(window).height();

    if ($("#confirm-address").length == 1) {
        var map_height = max_height - 180;
        $('#map-canvas').css({
            'max-height': max_height - $("#modal-content").height(),
            'height': map_height
        });
        $('.messi-box').css({
            'max-height': max_height
        });
        $('.messi.messi-fade').css({
            'left': width,
            'top': "0px",
            'max-height': max_height
        });
    } else {
        var map_height = max_height - 100;
        $('#map-canvas').css({
            'max-height': max_height,
            'height': map_height
        });
        $('.messi-box').css({
            'max-height': max_height
        });
        $('.messi.messi-fade').css({
            'left': width,
            'top': "15px",
            'max-height': max_height
        });
    }
}