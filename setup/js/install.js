// loading screen
var waitingDialog = waitingDialog || (function($) {
    'use strict';

    // Creating modal dialog's DOM
    var $dialog = $(
        '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
        '<div class="modal-dialog modal-m">' +
        '<div class="modal-content">' +
        '<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
        '<div class="modal-body">' +
        '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
        '</div>' +
        '</div></div></div>');

    return {
        /**
         * Opens our dialog
         * @param message Custom message
         * @param options Custom options:
         *                options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
         *                options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
         */
        show: function(message, options) {
            // Assigning defaults
            if (typeof options === 'undefined') {
                options = {};
            }
            if (typeof message === 'undefined') {
                message = 'Installing ... Please wait a few minutes !';
            }
            var settings = $.extend({
                dialogSize: 'm',
                progressType: '',
                onHide: null // This callback runs after the dialog was hidden
            }, options);

            // Configuring dialog
            $dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
            $dialog.find('.progress-bar').attr('class', 'progress-bar');
            if (settings.progressType) {
                $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
            }
            $dialog.find('h3').text(message);
            // Adding callbacks
            if (typeof settings.onHide === 'function') {
                $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function(e) {
                    settings.onHide.call($dialog);
                });
            }
            // Opening dialog
            $dialog.modal();
        },
        /**
         * Closes dialog
         */
        hide: function() {
            $dialog.modal('hide');
        }
    };

})(jQuery);


$(document).ready(function() {
    if ($.uniform) {
        $('input, textarea').uniform()
    };
    $("#installForm").validate({
        rules: {
            'config[base_url]': {
                required: true,
                domain: true,
            },
            'config[encryption_key]': {
                required: true,
                alphanumeric: true,
            },
            'db[default][dbprefix]': {
                required: false,
                minlength: 2,
                alphanumeric: true
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
            'db[default][confirmPassword]': {
                required: true,
                equalTo: "#password",
            },
        },
        messages: {
            'config[base_url]': {
                required: "Please enter a base URL",
                domain: "Please enter a valid URL.",
            },
            'config[encryption_key]': {
                required: "Please enter a encryption key",
                alphanumeric: "Please enter a valid key.",
            },
            'db[default][dbprefix]': {
                minlength: "Your table prefix must consist of at least 2 characters",
                alphanumeric: 'Only alphanumeric characters'
            },
            'db[default][hostname]': {
                required: "Please input host name",
                hostname: "Please enter a valid hostname.",
            },
            'db[default][database]': {
                required: "Please input database name",
                minlength: "Your database name must consist of at least 4 characters",
                databaseName: "Please enter a valid database name"
            },
            'db[default][username]': {
                required: "Please input username"
            },
            'db[default][password]': {
                required: "Please input password"
            },
            'db[default][confirmPassword]': {
                required: "Please input a confirm password",
                equalTo: "Please input a same password",
            },
        },
        submitHandler: function(form) {
            // some other code
            // maybe disabling submit button
            // then:
            var data = $(form).serialize();
            console.log(data);

            // show loading screen
            waitingDialog.show();

            $.ajax({
                url: 'setup/processing.php',
                method: "POST",
                data: data,
                success: function(response) {
                    if (response) {
                        var result = JSON.parse(response);
                        $("#error-handle").modal('show');
                        $("#error-handle").find('.modal-body').html('');
                        for (var i = 0; i < result.message.length; i++) {
                            var alert = '<div class="alert alert-' + result.message[i]['type'] + '"> \
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> \
                                            <strong>' + result.message[i]['title'] + '!</strong> ' + $.trim(result.message[i]['content']) + ' \
                                        </div>';
                            $("#error-handle").find('.modal-body').append(alert);
                        };
                    }
                    waitingDialog.hide();
                }
            });
            // $(form).submit();
            return false;
        }
    });

    // add/remove htpassword rules
    $('input[name="global[htpassword][value]"]').on('change', function() {
        if ($(this).is(':checked')) {
            $('textarea[name="global[htpassword][content]"]').rules('add', {
                required: true,
            });
        } else {
            $('textarea[name="global[htpassword][content]"]').rules('add', {
                required: false,
            });
        };
        $('textarea[name="global[htpassword][content]"].error').each(function() {
            $(this).valid();
        });
    });

})

if (jQuery.validator) {
    jQuery.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
    });
    jQuery.validator.addMethod("hostname", function(value, element) {
        // allow any non-whitespace characters as the host part
        return this.optional(element) || /^[a-zA-Z0-9-.]+$/.test(value);
    }, 'Please enter a valid hostname.');
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "Letters only please");
    jQuery.validator.addMethod("url", function(value, element) {
        return this.optional(element) || /^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(value);
    }, "Please enter a valid URL.");
    jQuery.validator.addMethod("domain", function(nname) {
        if (nname.search(/localhost/i) >= 0 || nname.search(/http:\/\/localhost/i) >= 0) {
            return true;
        };
        nname = nname.replace('http://', '');
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
    }, 'Invalid domain name.');
    jQuery.validator.addMethod("databaseName", function(value, element) {
        // allow any non-whitespace characters as the host part
        return this.optional(element) || /^([\w\s,]*)+[a-zA-Z0-9_]+[a-zA-Z]+$/.test(value);
    }, 'Please enter a valid database name.');
};
