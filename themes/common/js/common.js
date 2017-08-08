/**
 * Created with Sublime Text 2.
 * User: PhuTv.
 */


function Messi_data() {
    this.message = lang['json_parse_error'];
    this.class = 'error';
    this.modal = 0;
    this.title = lang['get_data_error'];
}

Messi_data.prototype.toArray = function() {
    x = [];
    $.each(this, function(i, n) {
        x[i] = n;
    });
    return x;
}

clone = function (obj) {
    return JSON.parse(JSON.stringify(obj));
}

serialize = function(obj, prefix) {
    var str = [],
        p;
    for (p in obj) {
        if (obj.hasOwnProperty(p)) {
            var k = prefix ? prefix + "[" + p + "]" : p,
                v = obj[p];
            str.push((v !== null && typeof v === "object") ?
                serialize(v, k) :
                encodeURIComponent(k) + "=" + encodeURIComponent(v));
        }
    }
    return str.join("&");
}

$(document).ready(function() {

    var redirect_In, redirect_Out;

    time_in = 1;

    time_check = 1;

    var time = 10;

    /* Get setting error display */
    error = $('#error_flag').val();

    title_mess = $('#title_mess').val();

    type_mess = $('#type_mess').val();

    error_timeout = $('#error_timeout').val();

    is_modal_mess = $('#is_modal_mess').val();

    if (is_modal_mess) {

        modal = true;

    } else {

        modal = false;

    }

    if (error > 0) {

        /* Display error message */
        convert_messi(title_mess, $('#error_mess').val(), type_mess, error_timeout, modal);

        $('#error_mess').val("");

        $('#error_flag').val(0);

    };

    // Init

    var center_div = $('div.center');

    var c_width = center_div.width();

    var w_width = $('body').width();

    var margin = (w_width - c_width) / 2;

    center_div.css({

        'margin-left': margin / w_width * 100 - 3 + '%',

        'margin-right': margin / w_width * 100 + '%'

    });

    var left_content = $('div.left_content');

    var right_content = $('div.right_content');

    left_content.css({

        'min-height': right_content.height()

    });

    $('input[type=reset]').click(function() {

        $('input[type=password]').keypress();

    });

    // End init

});

function guid() {
    function s4() {
        return Math.floor((1 + Math.random()) * 0x10000)
            .toString(16)
            .substring(1);
    }
    return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
        s4() + '-' + s4() + s4() + s4();
}

function getTarget(e) {

    var elem, evt = e ? e : event;

    if (evt.srcElement) elem = evt.srcElement;

    else if (evt.target) elem = evt.target;

    return elem;

}

serialize = function(obj, prefix) {
    var str = [];
    for (var p in obj) {
        if (obj.hasOwnProperty(p)) {
            var k = prefix ? prefix + "[" + p + "]" : p,
                v = obj[p];
            str.push(typeof v == "object" ?
                serialize(v, k) :
                encodeURIComponent(k) + "=" + encodeURIComponent(v));
        }
    }
    return str.join("&");
}


/**
 * [convert_messi convert messi message to dropdown notification]
 * @param  {[string]} title         [title of notify]
 * @param  {[string]} message       [message body]
 * @param  {[string]} class_mess    [class css of type notification]
 * @param  {[integer]} error_timeout [time display notify]
 * @return {[null]}               [description]
 */
function convert_messi(title, message, class_mess, error_timeout, modal) {

    var messi = new Array();

    messi['title'] = title;

    messi['message'] = message;

    messi['class'] = class_mess;

    messi['error_timeout'] = error_timeout;

    messi['modal'] = modal;

    show_messi(messi);

}

/**
 * [show_messi show notify form setting]
 * @param  {[array string]} messi [is array setting messi]
 * @return {[null]}       [description]
 */
function show_messi(messi) {

    if (typeof messi == "undefined") {
        
        return false;

    };

    var error_timeout = 2000;

    var is_modal = false;

    if (messi['modal']) {

        is_modal = messi['modal'];

    };

    if (messi['message'] == null || messi['message'] == '') {

        return;

    };

    var buttons = [{ id: "confirm", label: lang['confirm'], val: 'Y' }];

    if (messi['buttons']) {

        buttons = messi['buttons'];

    };

    if (is_modal) {

        new Messi(messi['message'], {

            title: messi['title'],

            titleClass: 'anim ' + messi['class'],

            buttons: buttons

        });

    } else {

        if (messi['class'] == 'success') {

            messi['class'] = 'notyfy_success';

        } else if (messi['class'] == 'warning') {

            messi['class'] = 'notyfy_warning';

        } else {

            messi['class'] = 'notyfy_error';

        }

        $('#notyfy_container_top').remove();

        $(".messi-modal").remove();

        $('body').prepend('<ul id="notyfy_container_top" class="notyfy_container i-am-new" style="display: none; cursor: pointer;"><li class="notyfy_wrapper ' + messi['class'] + '" style="display: block; cursor: pointer;"><div id="notyfy_312147093313744500" class="notyfy_bar"><div class="notyfy_message"><span class="notyfy_text">' + messi['title'] + ': <strong>' + messi['message'] + '</strong></span></div></div></li></ul>');

        $('#notyfy_container_top').slideDown(function() {

            $('#notyfy_container_top').click(function() {

                $('#notyfy_312147093313744500').slideUp(function() {

                    $('#notyfy_container_top').remove();

                    $(".messi-modal").remove();

                });

            });

            if (messi['error_timeout']) {

                error_timeout = parseInt(messi['error_timeout']);

            };

            setTimeout(function() {

                $('#notyfy_312147093313744500').slideUp(function() {

                    $('#notyfy_container_top').remove();

                    $(".messi-modal").remove();

                });

            }, error_timeout);

            return;

        });

    }

}

/**
 * [init_base_url get main url of server]
 * @param  {[string]} base_url [is protocol of request (http or https)]
 * @return {[string]}          [main url (no control, no parameter)]
 */
function init_base_url(base_url) {

    var url = window.location.href;

    url = url.replace("http://", "");

    var urlExplode = url.split("/");

    for (var i = 0; i < urlExplode.length; i++) {

        base_url += '/' + urlExplode[i];

        if (urlExplode[i] == 'index.php') {

            break;

        }

    };

    return base_url;
}

function check_access(result) {

    if (result.trim().toString() == WRONG_METHOD_SECURITY_CODE) {

        convert_messi(lang['Warning'], lang['Wrong_method_access'], 'warning', 3000, 1);

        return false;

    } else if (result.trim().toString() == TIMEOUT_SECURITY_CODE) {

        var time = 10;

        if (typeof time_in == 'undefined') {

            time_in = 0;

        };

        convert_messi(lang['Warning'], lang['session_has_expired_redirect_message_1'] + ' ' + Math.abs(time - time_in) + ' ' + lang['seconds'], 'warning', 11000, 1);

        if (typeof redirect_In != "undefined") {

            clearInterval(redirect_In);

        };

        if (typeof redirect_Out != "undefined") {

            clearTimeout(redirect_Out);

        };

        redirect_In = setInterval(function() {

            time_check = Math.abs(time - time_in);

            time_in++;

            $('.messi-content').html(lang['session_has_expired_redirect_message_1'] + ' ' + time_check + ' ' + lang['seconds']);

            if (time_check <= 0) {

                window.location.href = APP_BASE_URL + "index.php/login.html";

            };

        }, 1000);

        return false;

    } else {

        return result;

    }

}

function ajax_loader(arr) {

    ajx = Array();

    if (typeof arr['url'] != 'undefined') {

        ajx['url'] = arr['url'];

    } else {

        ajx['url'] = window.location.href;

    }

    if (typeof arr['method'] != 'undefined') {

        ajx['method'] = arr['method'];

    } else {

        ajx['method'] = 'POST';

    }
    if (typeof arr['data'] != 'undefined') {

        ajx['data'] = arr['data'];

    } else {

        ajx['data'] = null;

    }
    if (typeof arr['datatype'] != 'undefined') {

        ajx['datatype'] = arr['datatype'];

    } else {

        ajx['datatype'] = 'html';

    }

    if (typeof arr['async'] != 'undefined') {

        ajx['async'] = arr['async'];

    } else {

        ajx['async'] = true;

    }

    if (typeof arr['silent'] == 'undefined') {

        overlay.silent(0);

    } else {

        overlay.silent(arr['silent']);

    }

    return $.ajax({
        url: arr['url'],
        type: 'POST',
        data: ajx['data'],
        dataType: ajx['datatype'],
        cache: false,
        async: ajx['async'],
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            //Download progress
            xhr.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    $("#loader p.loader_description").html(lang['Processing_3_dot'] + ' ' + Math.round(percentComplete * 100) + "%");
                }
            }, false);
            return xhr;
        },

        beforeSend: function(xhr, opts) {

            if (typeof arr['is_save'] != 'undefined') {

                ajax_before_save();

            } else {

                ajax_before();

            }

        },
        success: function(response) {

            if (!check_access(response)) {

                $("#loader").remove();

                return false;

            };

            var get_data = null;

            if (is_json(response)) {

                get_data = JSON.parse(response);

            }

            if (typeof get_data == 'object' && get_data !== null) {

                if (typeof get_data.success != "undefined" && get_data.success) {

                    if (typeof arr['is_save'] != 'undefined') {

                        ajax_success_save(get_data);

                    } else {

                        if (typeof get_data.modal != "undefined" && get_data.modal) {

                            show_messi_modal(get_data, response);

                        } else {

                            ajax_success(get_data);

                        }

                    }

                    if (typeof arr['callback'] == 'function') {

                        arr['callback'].call(this, get_data, arr['form']);

                        return response;

                    };

                } else {

                    if (typeof get_data.modal != "undefined" && get_data.modal) {

                        show_messi_modal(get_data, response);

                    } else {

                        ajax_error(get_data.message);

                    }

                }

            } else {

                if (get_data != null && typeof get_data.message != 'undefined') {

                    if (typeof get_data.modal != "undefined" && get_data.modal) {

                        show_messi_modal(get_data, response);

                    } else {

                        ajax_error(get_data.message);

                    }

                } else {

                    show_messi_modal(get_data, response);

                }

            }

            return response;

        },
        error: function(jqXHR, exception) {

            var msg = '';

            if (jqXHR.status === 0) {

                msg = lang['Not_connect_Verify_Network'];

            } else if (jqXHR.status == 404) {

                msg = lang['Requested_page_not_found_404'];

            } else if (jqXHR.status == 500) {
                msg = lang['Internal_Server_Error_500'];

            } else if (exception === 'parsererror') {

                msg = lang['Requested_JSON_parse_failed'];

            } else if (exception === 'timeout') {

                msg = lang['Time_out_error'];

            } else if (exception === 'abort') {

                msg = lang['Ajax_request_aborted'];

            } else {

                msg = lang['Uncaught_Error'] + '\n' + jqXHR.responseText;

            }

            show_messi_modal({
                message: msg
            });

            return jqXHR;

        }

    }).responseText;

}


function show_messi_modal(get_data, data) {

    ajax_error();

    messi_data = new Messi_data();

    messi_data.modal = true;

    var result = $.extend({}, messi_data, get_data);

    if (!is_json(data)) {

        result.message += '<hr>' + data.toString();

    };

    $('#loader').remove();

    show_messi(result.toArray());

}


function ajax_before() {

    if (!overlay.isSilent()) {

        $(".messi.messi-fade").css({
            "z-index": '0'
        });

        overlay.display();

    };

}

function ajax_before_save() {

    if (!overlay.isSilent()) {

        $("body").append('<div id="loader" style="z-index: 99999;position: fixed;left: 48%;top: 48%;"><img src="' + APP_BASE_URL + '/themes/common/images/ajax_loader_blue_32.gif" style="" height="32" width="32" id="img_before" alt="loading"><span id="text" style="color: green; line-height: 20px;font-weight: bold;">Saving ...</span></div>');

    };
}


function ajax_success_save(data) {

    if (!overlay.isSilent()) {

        $("#img_before").attr('src', APP_BASE_URL + '/themes/common/images/checked.png');

        $('#loader #text').html(data.message).parent().fadeOut(1000);

        overlay.silent(0);

    };

}

function ajax_success(response) {

    if (!overlay.isSilent()) {

        overlay.gone();

        $("#loader").remove();

        $(".messi.messi-fade").css({
            "z-index": '10000'
        });

        var messi = new Array();

        messi['title'] = lang['Success'];

        messi['message'] = response.message;

        messi['class'] = 'success';

        show_messi(messi);

        if (typeof response.redirect != "undefined" && response.redirect) {

            if (typeof response.timeout != "undefined" && response.timeout) {

                var timeout = parseInt(response.timeout);

                setTimeout(function() {

                    window.location.href = response.redirect;

                }, timeout);

            } else {

                window.location.href = response.redirect;

            }

        };

        overlay.silent(0);

    }

}

function ajax_error(err) {

    overlay.gone();

    $(".messi.messi-fade").css({
        "z-index": '10000'
    });

    $("#loader").remove();

    var messi = new Array();

    messi['title'] = lang['Error'];

    messi['message'] = err;

    messi['class'] = 'error';

    show_messi(messi);

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



function show_error_session_expire() {

    convert_messi(lang['Warning'], lang['session_has_expired_redirect_message_1'] + ' ' + Math.abs(time - time_in) + ' ' + lang['seconds'], 'warning', 11000, 1);

    var time = 10;

    setInterval(function() {

        time = time - 1;

        $('.messi-content').html(lang['session_has_expired_redirect_message_1'] + ' ' + Math.abs(time - time_in) + ' ' + lang['seconds']);

    }, 1000);

    $(".messi-box button#confirm").click(function () {

        window.location.href = APP_BASE_URL + "index.php/login.html";

    });

    setTimeout(function() {

        window.location.href = APP_BASE_URL + "index.php/login.html";

    }, 10000);

}



function html_entities(str) {

    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');

}

function is_json(str) {

    try {

        JSON.parse(str);

    } catch (e) {

        return false;

    }

    return true;

}

if ($.validator) {

    $.validator.addMethod('extension', function(value, element, param) {
        var ext = element.files[0].name.slice((element.files[0].name.lastIndexOf(".") - 1 >>> 0) + 2);
        var arrExt = param.toLowerCase().split(',');
        var valid = $.inArray(ext.toLowerCase(), arrExt) >= 0;
        return this.optional(element) || valid;
    }, lang['Extension_must_be_less_than_0']);

    $.validator.addMethod('filesize', function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    }, lang['File_size_must_be_less_than_0']);

    $.validator.addMethod("routeFormat", function(value, element) {
        // allow any non-whitespace characters as the host part
        return this.optional(element) || /^([a-zA-Z0-9\/_-.])+$/.test(value);
    }, lang['Please_enter_a_valid_Route_format']);

    $.validator.addMethod("specialCharsDisable", function(value, element) {
        return this.optional(element) || /^([\w,]*)+[a-zA-Z0-9._\-\s]+$/i.test(value);
    }, lang['Letters_numbers_and_underscores_only_please']);

    $.validator.addMethod("lang_key", function(value, element) {
        // allow any non-whitespace characters as the host part
        return this.optional(element) || /^[a-zA-Z0-9_]+[a-zA-Z0-9]+$/.test(value);
    }, lang['Please_enter_a_valid_language_key']);

    $.validator.addMethod("hostname", function(value, element) {
        // allow any non-whitespace characters as the host part
        return this.optional(element) || /^[a-zA-Z0-9-.]+$/.test(value);
    }, lang['Please_enter_a_valid_hostname']);

    $.validator.addMethod("file_name", function(value, element) {
        return this.optional(element) || /^[a-zA-Z_]+$/i.test(value);
    }, lang["Please_enter_alphabetic_and_underline_character"]);

    $.validator.addMethod("url", function(value, element) {
        return this.optional(element) || /^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(value);
    }, lang['Please_enter_a_valid_URL']);

    $.validator.addMethod("domain", function(nname) {
        if (nname.search(/localhost/i) >= 0 || nname.search(/http:\/\/localhost/i) >= 0) {
            return true;
        };
        name = nname.replace('http://', '');
        nname = nname.replace('https://', '');
        var arr = new Array(
            '.com', '.net', '.org', '.biz', '.coop', '.info', '.museum', '.name',
            '.pro', '.edu', '.gov', '.int', '.mil', '.ac', '.ad', '.ae', '.af', '.ag',
            '.ai', '.al', '.am', '.an', '.ao', '.aq', '.ar', '.as', '.at', '.au', '.aw',
            '.az', '.ba', '.bb', '.bd', '.be', '.bf', '.bg', '.bh', '.bi', '.bj', '.bm',
            '.bn', '.bo', '.br', '.bs', '.bt', '.bv', '.bw', '.by', '.bz', '.ca', '.cc',
            '.cd', '.cf', '.cg', '.ch', '.ci', '.ck', '.cl', '.cm', '.cn', '.co', '.cr',
            '.cu', '.cv', '.cx', '.cy', '.cz', '.de', '.dj', '.dk', '.dm', '.do', '.dz',
            '.ec', '.ee', '.eg', '.eh', '.er', '.es', '.et', '.fi', '.fj', '.fk', '.fm',
            '.fo', '.fr', '.ga', '.gd', '.ge', '.gf', '.gg', '.gh', '.gi', '.gl', '.gm',
            '.gn', '.gp', '.gq', '.gr', '.gs', '.gt', '.gu', '.gv', '.gy', '.hk', '.hm',
            '.hn', '.hr', '.ht', '.hu', '.id', '.ie', '.il', '.im', '.in', '.io', '.iq',
            '.ir', '.is', '.it', '.je', '.jm', '.jo', '.jp', '.ke', '.kg', '.kh', '.ki',
            '.km', '.kn', '.kp', '.kr', '.kw', '.ky', '.kz', '.la', '.lb', '.lc', '.li',
            '.lk', '.lr', '.ls', '.lt', '.lu', '.lv', '.ly', '.ma', '.mc', '.md', '.mg',
            '.mh', '.mk', '.ml', '.mm', '.mn', '.mo', '.mp', '.mq', '.mr', '.ms', '.mt',
            '.mu', '.mv', '.mw', '.mx', '.my', '.mz', '.na', '.nc', '.ne', '.nf', '.ng',
            '.ni', '.nl', '.no', '.np', '.nr', '.nu', '.nz', '.om', '.pa', '.pe', '.pf',
            '.pg', '.ph', '.pk', '.pl', '.pm', '.pn', '.pr', '.ps', '.pt', '.pw', '.py',
            '.qa', '.re', '.ro', '.rw', '.ru', '.sa', '.sb', '.sc', '.sd', '.se', '.sg',
            '.sh', '.si', '.sj', '.sk', '.sl', '.sm', '.sn', '.so', '.sr', '.st', '.sv',
            '.sy', '.sz', '.tc', '.td', '.tf', '.tg', '.th', '.tj', '.tk', '.tm', '.tn',
            '.to', '.tp', '.tr', '.tt', '.tv', '.tw', '.tz', '.ua', '.ug', '.uk', '.um',
            '.us', '.uy', '.uz', '.va', '.vc', '.ve', '.vg', '.vi', '.vn', '.vu', '.ws',
            '.wf', '.ye', '.yt', '.yu', '.za', '.zm', '.zw');
        var mai = nname;
        var val = true;
        var dot = mai.lastIndexOf(".");
        var dname = mai.substring(0, dot);
        var ext = mai.substring(dot, mai.length);
        if (dot > 2 && dot < 57) {
            for (var i = 0; i < arr.length; i++) {
                if (ext == arr[i]) {
                    val = true;
                    break;
                } else {
                    val = false;
                }
            }
            if (val == false) {
                return false;
            } else {
                for (var j = 0; j < dname.length; j++) {
                    var dh = dname.charAt(j);
                    var hh = dh.charCodeAt(0);
                    if ((hh > 47 && hh < 59) || (hh > 64 && hh < 91) || (hh > 96 && hh < 123) || hh == 45 || hh == 46) {
                        if ((j == 0 || j == dname.length - 1) && hh == 45) {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }
            }
        } else {
            return false;
        }
        return true;
    }, lang['Invalid_domain_name']);

    $.validator.addMethod("databaseName", function(value, element) {
        // allow any non-whitespace characters as the host part
        return this.optional(element) || /^([\w\s,]*)+[a-zA-Z0-9_]+[a-zA-Z]+$/.test(value);
    }, lang['Please_enter_a_valid_database_name']);

    $.validator.addMethod("folder_name", function(value, element) {
        // allow any non-whitespace characters as the host part
        return this.optional(element) || /^([\w\s,]*)+[a-zA-Z0-9_\/.\-]+$/.test(value);
    }, lang['Please_enter_a_valid_folder_name']);

};
