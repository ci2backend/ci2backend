(function($) {
    jQuery.fn.Overlay = function(opt) {

        // Get timestamp
        var timestamp = Math.floor(Date.now() / 1000);

        // Default settings
        var defaults = {
            silent: !1,
            loader: '',
            id_loader: '#loader',
            img_width: 32,
            classOverlay: 'dark',
            img: 'default.gif'
        };

        this.opt = $.extend({}, defaults, opt);

        /* Start building resources of Plugin*/
        var _this = this;

        _this.setOptions = function(opt) {
            this.opt = $.extend({}, defaults, opt);
        }

        _this.silent = function(silent) {
            this.opt.silent = silent;
        }

        _this.isSilent = function() {
            return this.opt.silent;
        }

        _this.display = function() {
            if (this.opt.silent) {
                return true;
            };
            this.addClass(this.opt.classOverlay).show();
            $(this.opt.id_loader).show();
            $w_win = $(window).width();
            $h_win = $(window).height();
            $w_img = this.opt.img_width;
            $h_img = this.opt.img_width;
            $left = ($w_win - $w_img) / 2;
            $top = ($h_win - $h_img) / 2;
            $(this.opt.id_loader).find('.img_before').css({
                "z-index": '10000',
                "position": "fixed",
                "top": $top,
                "left": $left
            });
            $(this.opt.loader).find('p.loader_description').css({
                "top": $top,
            });
        };

        _this.gone = function() {
            this.hide();
            $(this.opt.id_loader).hide();
        };

        _this.buildLoader = function() {
            this.opt.loader = '<div id="loader" style="display: none;"> \
            <img width="' + this.opt.img_width +  '" src="' + APP_BASE_URL + '/assets/extensions/overlay/img/' + this.opt.img + '" style="" class="img_before" alt="loading"> \
            <p class="loader_description"> ' + lang['Processing_3_dot'] + ' </p> \
            </div>';
            this.opt.loader = $("body").append(this.opt.loader);
        };

        /* Inital resources of Plugin*/
        _this.init = function() {
            this.buildLoader();
            return this;
        };
        return _this.init();
    };
})(jQuery);

overlay = $("#overlay").Overlay();