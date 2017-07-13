/*
 * Created with Sublime Text 2.
 * User: PHUTV
 * Date: 2017-06-03
 * Time: 23:08:06
 * Contact: truong.van.phu@ci2backend.com
 */
uniform = $('textarea, span.uniform, a[type="button"], button[type="submit"], button[type="button"], input[type="search"], input[type="file"], input[type="password"], input[type="reset"], input[type="button"], input[type="submit"], input[type="checkbox"], input[type="text"], input[type="email"], input[type="tel"], input[type="radio"], select, textarea');
confirmation_options = {
    onConfirm: delete_action,
    placement: 'left'
}

// Initiate tablesorter script
window.onpopstate = function(e) {
    if (e.state) {
        document.documentElement.innerHTML = e.state.html;
        document.title = e.state.title;
    }
};
$(document).ready(function() {
    modalGetValue('.modalGetValue');
    $(document).on('click', 'input[type="checkbox"].toggle-selected', function() {
        var form = $(this).parents('form');
        if (!$(this).is(":checked")) {
            $(this).parent('span.checked').removeClass('checked');
        } else {
            $(this).parent('span').addClass('checked');
        }
        toggleSelected(!$(this).is(":checked"), form);
    });
    $(document).on('change', '#table-group-action', function(event) {
        ele = getTarget(event);
        event.preventDefault();
        var target_id = $(ele).parents('form').attr('target-id');
        var table = document.getElementById(target_id);
        checker = $(table).find("tbody input:checked");
        var checked = $(table).find("input:checked").length;
        var action_selector = $(ele).val();
        var isConfirm = $('option:selected', ele).data('confirmation');
        if (checked && isConfirm && action_selector) {
            var option_box = {
                buttons: {
                    cancel: {
                        label: lang['Cancel']
                    }
                },
                buttons: {
                    cancel: {
                        'className': 'btn btn-danger',
                        label: '<i class="fa fa-times"></i> ' + lang['Cancel'],
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> ' + lang['confirm']
                    }
                },
                title: '<span class="label label-info">' + lang['confirm'] + '</span>',
                message: lang['Are_you_sure_you_want_to'],
                callback: function(result) {
                    if (result === true) {
                        $.each(checker, function(index, item) {
                            action_ele = $(item).parents('tr').find('.' + action_selector);
                            if (action_ele.length && typeof window[action_selector] == 'function') {
                                window[action_selector].call(this, action_ele);
                            };
                        });
                    }
                    $(ele).val(0);
                    return true;
                }
            }
            installBootbox(option_box, 'confirm');
        } else {
            if (isConfirm) {
                var option_box = {
                    title: '<span class="label label-danger">' + lang['confirm'] + '</span>',
                    message: lang['message_checker']
                }
                installBootbox(option_box, 'alert');
            } else {
                var selector = $(this).parents('form');
                if (selector.length && typeof window[action_selector] == 'function') {
                    window[action_selector].call(this, selector);
                    $(ele).val(0);
                };
            }
        }
        $(ele).val(0);
    });
    $(document).on('change', ".onchange_this.reload", function () {
        window.location.href = $(this).val();
    });
    $(document).on('change', 'select', function(event) {
        if ($(this).hasClass('data-auto-load')) {
            var that = this;
            var url = $(this).data('load-url');
            if (typeof url == "undefined") {
                return false;
            };
            $.getJSON(url + '/' + $(this).val(), function(data) {
                if (data) {
                    var callback = $(that).data('callback');
                    var target = $(that).data('target');
                    if (typeof window[callback] == 'function') {
                        window[callback].call(this, target, data);
                    };
                } else {
                    console.log('No data response');
                }
            });
        };
    });
    $(document).on('click', 'a[data-toggle="tab"]', function(event) {
        var target = $(this).data('target');
        if (target) {
            var url = APP_BASE_URL + target.replace('#', '') + '.html';
            var html = $('html')[0].innerHTML;
            window.history.pushState({
                html: html,
                title: document.title
            }, document.title, url);
        };
        updateUniform(uniform);
    });
    $('div.modal').on('shown.bs.modal', function() {
        var selects = $(this).find('select');
        $.each(selects, function(i, select) {
            if ($(select).hasClass('data-auto-load') && $(select).hasClass('data-init-load')) {
                var url = $(select).data('load-url');
                if (typeof url == "undefined") {
                    return false;
                };
                $.getJSON(url, function(data) {
                    console.log(data);
                    if (data) {
                        var callback = $(select).data('callback');
                        if (typeof window[callback] == 'function') {
                            window[callback].call(this, select, data);
                        };
                    } else {
                        console.log('No data response');
                    }
                });
            };
        });
    });
    // install password trength
    passwordTrength('.password, input[type="password"]');
    // install validation in form submit
    formValidation();
    // install uniform
    installUniform(uniform);
    // Common install table
    installTableSorter("#myTable", "#pager");
});
$(window).scroll(function() {
    if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
        $('.action-fixed-hide').removeClass('visible').addClass('invisible');
        $('.action-fixed-target').removeClass('invisible').addClass('visible');
    } else {
        $('.action-fixed-target').removeClass('visible').addClass('invisible');
        $('.action-fixed-hide').removeClass('invisible').addClass('visible');
    }
});

function installConfirmation(selector) {
    if ($.fn.confirmation) {
        $(selector).confirmation(confirmation_options);
    };
}

function passwordTrength(selector) {
    if ($.fn.pstrength) {
        $(selector).pstrength();
    };
}

function installUniform(element) {
    if ($.uniform) {
        // Apply the agent theme selectively
        $('input.agent').uniform({ wrapperClass: "uniform-agent" });
        $.each(element, function(i, uni) {
            if ($(uni).hasClass('uniform') && $(uni).is(":visible")) {
                if ($(uni).hasClass('form-control')) {
                    $(uni).removeClass('form-control').uniform({ activeClass: 'myActiveClass' }).addClass('form-control');
                } else {
                    $(uni).uniform();
                }
            };
        });
    };
}

function updateUniform(element) {
    if (element) {
        installUniform(element);
    };
}

function installTableSorter(tb_id, page_id) {
    if ($(tb_id).find('tbody tr').length > 0) {
        $(tb_id).tablesorter({
            // zebra coloring
            widgets: ['zebra'],
            // pass the headers argument and assing a object 
            headers: {
                0: { sorter: false }
            },
            pager_css: {
                container: 'tablesorter-pager',
                errorRow: 'tablesorter-errorRow', // error information row (don't include period at beginning)
                disabled: 'disabled' // class added to arrows @ extremes (i.e. prev/first arrows "disabled" on first page)
            }
        }).tablesorterPager({ container: $(page_id) });
        $('select.pagesize').change('select.pagesize', function() {
            updateUniform();
            installConfirmation('[data-toggle="confirmation"]');
        });
        $('img.first, img.prev, img.next, img.last').click('img.first, img.prev, img.next, img.last', function() {
            updateUniform();
            installConfirmation('[data-toggle="confirmation"]');
        });
        var tableSearch = installTableSearch(tb_id);
        installConfirmation('[data-toggle="confirmation"]');
    };
}

function installTableSearch(tb_id, grid, options) {
    if (typeof grid == "undefined") {
        grid = 'grid_4 text-right pull-right grid';
    };
    var opts = {
        divObj: '<div class="' + grid + ' table-search"></div>',
        searchText: '<label for="" class="control-label"> ' + lang['search_table'] + ' : </label>',
        searchPlaceHolder: lang['Enter_search_value'],
        inputClass: 'input-short uniform search-input'
    };
    if (options) {
        opts = $.extend(options, opts);
    };
    tb_id = $(tb_id).tableSearch(opts);
    $(document).on('keyup', 'input.search-input', function() {
        updateUniform();
    });
    installUniform($('.search-input'));
    return tb_id;
}

function delete_action(event) {
    if (event.length) {
        evt = event;
    } else {
        event.preventDefault();
        evt = getTarget(event);
    }
    var data = $(evt).attr('target');
    if (typeof data == "undefined") {
        data = $(evt).data('target');
    };
    if (is_json(data) || typeof data == 'object') {
        if (is_json(data)) {
            data = JSON.parse(data);
        };
        if (data) {
            var ajx = Array();
            ajx['url'] = APP_BASE_URL + 'dev/delete';
            ajx['data'] = serialize(data);
            ajx['async'] = false;
            ajx['callback'] = deleteSubmitCallback;
            ajx['form'] = $(evt);
            var result = ajax_loader(ajx);
            if (is_json(result)) {
                result = JSON.parse(result);
                if (result.success) {
                    if (typeof result.data.element != "undefined") {
                        $.each(result.data.element, function(index, item) {
                            $('tr[data-target="' + item + '"]').remove();
                        });
                        updateTableSorter();
                    };
                    return false;
                }
            }
        } else {
            $(evt).parents('tr').remove();
        }
    };
    return false;
}

function formValidation() {
    if (!$.validator) {
        return false;
    };
    $.each($('form.ajax.validate, form[method-submit="ajax"]'), function(index, form) {
        // jquery disable form submit on enter
        $(form).find('input[type="text"]').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $(form).validate({
            rules: {
                template_key: {
                    required: true,
                    folder_name: true
                },
                template_name: {
                    required: true,
                    specialCharsDisable: true
                },
                group_name: {
                    required: true
                },
                extension_key: {
                    required: true,
                    folder_name: true
                },
                extension_name: {
                    required: true,
                    specialCharsDisable: true
                },
                'config[permitted_uri_chars]': {
                    required: true,
                },
                model_name: {
                    required: true,
                    file_name: true
                },
                controller_name: {
                    required: true,
                    file_name: true
                },
                module_name: {
                    required: true,
                    folder_name: true
                },
                view_name: {
                    required: true,
                    file_name: true
                },
                db_new_name: {
                    required: true,
                    minlength: 4,
                    databaseName: true,
                },
                'db[default][dbprefix]': {
                    required: false,
                    minlength: 2,
                    file_name: true
                },
                'db[default][hostname]': {
                    required: true,
                    hostname: true
                },
                'db[default][database]': {
                    required: true,
                    minlength: 4,
                    databaseName: true
                },
                'db[default][username]': {
                    required: true,
                },
                'db[default][password]': {
                    required: true,
                },
                'config[base_url]': {
                    required: true,
                    url: true,
                },
                lang_display: {
                    required: true,
                },
                lang_key: {
                    required: true,
                    file_name: true
                },
                lang_folder: {
                    required: true,
                    file_name: true
                },
                constant: {
                    required: true,
                    remote: {
                        url: APP_BASE_URL + "my_constants/checkConstantExist",
                        type: "POST"
                    },
                    maxlength: 100
                },
                value: {
                    required: true,
                    maxlength: 100
                }
            },
            messages: {
                extension_name: {
                    required: lang['This_field_is_required'],
                },
                extension_key: {
                    required: lang['This_field_is_required'],
                },
                'config[permitted_uri_chars]': {
                    required: lang['This_field_is_required'],
                },
                model_name: {
                    required: lang['This_field_is_required'],
                },
                controller_name: {
                    required: lang['This_field_is_required'],
                },
                module_name: {
                    required: lang['This_field_is_required'],
                },
                view_name: {
                    required: lang['This_field_is_required'],
                },
                db_new_name: {
                    required: lang['This_field_is_required'],
                    minlength: lang['Your_database_name_must_consist_of_at_least_4_characters'],
                },
                'db[default][dbprefix]': {
                    minlength: lang['Your_table_prefix_must_consist_of_at_least_2_characters'],
                },
                'db[default][hostname]': {
                    required: lang['This_field_is_required'],
                },
                'db[default][database]': {
                    required: lang['This_field_is_required'],
                    minlength: lang['Your_database_name_must_consist_of_at_least_4_characters'],
                },
                'db[default][username]': {
                    required: lang['This_field_is_required']
                },
                'db[default][password]': {
                    required: lang['This_field_is_required']
                },
                'config[base_url]': {
                    required: lang['This_field_is_required'],
                },
                lang_display: {
                    required: lang['This_field_is_required']
                },
                lang_key: {
                    required: lang['This_field_is_required']
                },
                lang_folder: {
                    required: lang['This_field_is_required']
                },
                constant: {
                    required: lang['This_field_is_required'],
                    remote: lang['This_constant_is_exist'],
                    maxlength: lang['This_field_can_not_exceed_100_characters_in_length']
                },
                value: {
                    required: lang['This_field_is_required'],
                    maxlength: lang['This_field_can_not_exceed_100_characters_in_length']
                }
            },
            submitHandler: function(form) {
                var current = this.currentForm;
                if (form == current) {
                    formAjaxSubmit(form);
                };
                return false;
            }
        });
    });
}

function initChosen(el) {
    if ($(el)) {
        $(el).chosen();
    };
}

function initSelect(element, result) {
    if ($(element).length) {
        if (result.success) {
            var data = result.data;
            $(element).find('option').remove().end();
            $.each(data, function(key, value) {
                var opt_val = key;
                if (Object.keys(data)[0] == key) {
                    selected = opt_val;
                    $(element).append('<option selected="selected" value="' + opt_val + '">' + opt_val + ' - ' + value + '</option>').val(opt_val);
                } else {
                    $(element).append('<option value="' + opt_val + '">' + opt_val + ' - ' + value + '</option>').val(opt_val);
                }
                $(element).val(selected);
                $(element).trigger("chosen:updated");
            });
        };
    };
}

function updateSelect(element, result) {
    if ($(element).length) {
        if (result.success) {
            var data = result.data;
            $(element).find('option').remove().end();
            var controller = data.controller;
            var actions = data.action;
            var selected = '';
            for (var i = 0; i < actions.length; i++) {
                var opt_val = controller + '/' + actions[i];
                if (i == 0) {
                    selected = opt_val;
                    $(element).append('<option selected="selected" value="' + opt_val + '">' + actions[i] + '</option>').val(opt_val);
                } else {
                    $(element).append('<option value="' + opt_val + '">' + actions[i] + '</option>').val(opt_val);
                }
                $(element).val(selected);
                $(element).trigger("chosen:updated");
            };
        };
    };
}

function modalGetValue(el) {
    $(el).click(function() {
        var modal = $(this).data('modal');
        $(modal).modal('show');
        var onShowCallBack = $(modal).data('show-callback');
        $(modal).on('shown.bs.modal', function() {
            $('.chosen-select').trigger("chosen:updated");
            if (typeof window[onShowCallBack] == 'function') {
                window[onShowCallBack].call(this, $(this).find('.chosen-select'));
            };
        });
    });
}

function setFormData(data, form) {
    if (data) {
        for (var i = 0; i < data.length; i++) {
            form.find('[name="' + data[i].name + '"]').val(data[i].value);
        };
    };
}

function callbackModal(element, modal) {
    var data = $(element).serializeArray();
    var callback = $(element).attr('callback');
    var form = $(element).attr('form-element');
    if (typeof window[callback] == 'function') {
        window[callback].call(this, data, $(form));
        modal.modal('hide');
    };
}

function formAjaxSubmit(form) {
    $(form).find('input[type="submit"]').attr('disabled', 'disabled');
    var formData = $(form).serialize();
    var action = $(form).find('[name="before_operation_action"]').val();
    if (typeof action != "undefined") {
        var arr = {
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: APP_BASE_URL + 'index.php/dev/' + action, // the url where we want to POST
            data: formData, // our data object
            callback: formSubmitCallback,
            silent: 1,
            form: form
        }
        ajax_loader(arr);
    };

    var arr = {
        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
        url: $(form).attr('action'), // the url where we want to POST
        data: formData, // our data object
        callback: formSubmitCallback,
        silent: 0,
        form: form
    }
    var result = ajax_loader(arr);

    $(form).find('input[type="submit"]').removeAttr('disabled');
}

function formSubmitCallback(result, form) {
    if (typeof result.data != 'undefined' && result.data != null && result.success) {
        if (typeof result.callback_function != "undefined" && result.callback_function) {
            if (typeof window[result.callback_function] === 'function') {
                window[result.callback_function].call(this, result.data);
            } else {
                alert('The function ' + result.callback_function + ' is not found');
            }
        } else {
            if ($(form).find('input[name="callback_function"]').length > 0) {
                var func = $(form).find('input[name="callback_function"]').val();
                if (typeof window[func] == 'function') {
                    window[func].call(this, result.data);
                } else {
                    alert('The function ' + func + ' is not found');
                }
            };
        }
        $('input[name="db_old_name"]').val(result.data.db_new_name);
    };
    return true;
}

function toObject(arr) {
    var rv = {};
    for (var i = 0; i < arr.length; ++i)
        rv[i] = arr[i];
    return rv;
}

function updateTableSorter() {
    var usersTable = $(".tablesorter");
    usersTable.trigger("update")
        .trigger("sorton", [usersTable.get(0).config.sortList])
        .trigger("appendCache")
        .trigger("applyWidgets");
}

function selectAll(form) {
    var table_id = $(form).attr('target-id');
    var tableEle = document.getElementById(table_id);
    var inputs = $('input[type="checkbox"].action:not(.toggle-selected):visible');
    $.each(inputs, function(index, element) {
        $(element).prop('checked', 'checked');
    });
    updateUniform(inputs);
}

function deselectAll(form) {
    var table_id = $(form).attr('target-id');
    var tableEle = document.getElementById(table_id);
    var inputs = $('input[type="checkbox"].action:not(.toggle-selected):visible');
    $.each(inputs, function(index, element) {
        $(element).prop('checked', false);
    });
    updateUniform(inputs);
}

function toggleSelected(selected, form) {
    if (selected) {
        deselectAll(form);
    } else {
        selectAll(form);
    }
}

function installBootbox (opts, type) {
    if (typeof bootbox != "undefined") {
        bootbox[type](opts);
    }
    else {
        alert('Missing extension' + ' bootbox');
    }
}

function deleteSubmitCallback(data, element) {
    if (typeof data.success != "undefined" && typeof data.callback_function != 'undefined') {
        if (typeof window[data.callback_function] == 'function') {
            window[data.callback_function].call(this, data, element);
        };
    };
}
