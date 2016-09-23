/**
 * Created on 22.05.2016.
 */
function Scrollbox(options) {

    this.$scrollbox = $('.scrollbox');

    Object.defineProperty(this.$scrollbox, 'count', {
        get: function () {
            return $(this).find('.scroller-item').length;
        }
    });

    this.params = $.extend({}, {
        limit: 10,
        message: 'Ничего не найдено',
        hbs: this.$scrollbox.data('hbs'),
        ajax_url: this.$scrollbox.data('ajax-url'),
        filters: {}

    }, options);

    return this;
}

Scrollbox.prototype.listen = function () {
    var self = this;
    $(window).scroll(function (e) {
        $(window).scrollTop() + $(window).height() == $(document).height() && !$('#scroller-spinner').length && self.load();
    });
};

Scrollbox.prototype.init = function () {

    var self = this;

    self.listen();

    Object.isFill(this.params) && $.ajax({

        url: this.params['hbs'],
        cache: true,
        success: function (source) {
            self.render = Handlebars.compile(source);

            if (!self.$scrollbox.count) {
                self.load();
            }

            $('.scrollbox').data('scrollbox', self);
        }
    });
};

Scrollbox.prototype.load = function () {

    var self = this;

    $.ajax({

        url: self.params['ajax_url'],
        type: 'POST',
        dataType: 'JSON',
        data: {
            offset: self.$scrollbox.count,
            limit: self.params['limit'],
            filters: self.params.filters
        },
        beforeSend: function () {

            self.$scrollbox.append($('<i>', {
                id: 'scroller-spinner',
                class: 'fa fa-spinner fa-pulse fa-3x fa-fw',
                css: {
                    width: '100%',
                    padding: '20px 0'
                },
                'aria-hidden': true
            }));

            self.beforeSend instanceof Function && self.beforeSend();
        },
        success: function (data) {
            self.success instanceof Function && self.success(data, self.$scrollbox, self.render);

            if (data.length < self.params.limit) {
                $(window).off('scroll');
            }
        },
        error: function (err) {
            console.error(err);

            self.render && self.$scrollbox.empty().append(self.render({
                notyfication: 1,
                type: 'danger',
                message: 'Ошибка сервера'
            }));

            self.error instanceof Function && self.error(err);
        },
        complete: function () {
            $('#scroller-spinner').remove();

            self.complete instanceof Function && self.complete();
        }
    });
};

Scrollbox.prototype.refresh = function () {
    this.$scrollbox.empty();
    this.listen();
    this.load();
};

Scrollbox.prototype.render = null;
Scrollbox.prototype.beforeSend = null;
Scrollbox.prototype.success = null;
Scrollbox.prototype.error = null;
Scrollbox.prototype.complete = null;

$(function () {

    /**
     * @param obj
     * @returns {Array}
     */
    Object.values = function (obj) {
        return Object.keys(obj).map(function (key) {
            return obj[key];
        });
    };

    /**
     * check values of object
     * @param obj
     * @returns {boolean}
     */
    Object.isFill = function (obj) {
        return (
            Object.values(obj).indexOf(undefined) == -1
            &&
            Object.values(obj).indexOf(null) == -1
            &&
            Object.values(obj).indexOf('') == -1
        );
    };

    $.ajax({
        url: window.location.origin + '/bower_components/handlebars/handlebars.min.js',
        cache: true,
        dataType: 'script',
        success: function (script) {
        },
        error: function (err) {
            Scrollbox = null;
            console.error(err);
        }
    });
});