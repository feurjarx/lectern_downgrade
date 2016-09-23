/**
 * Created on 15.05.2016.
 */
function notification(options) {
    noty($.extend({}, {
        template: $('<div>', {
            class: 'noty_message',
            html: [
                $('<strong>', {
                    class: 'noty_text'
                }),
                $('<div>', {
                    class: 'noty_close'
                })
            ]
        }),
        layout: 'topRight',
        closeWith: ['click'],
        timeout: 2000,
        animation: {
            open: 'animated wobble',
            close: 'animated flipOutY'
        }
    }, options));
}

/**
 * ucfirst
 * @returns {string}
 */
String.prototype.ucfirst = function()
{
    return this.charAt(0).toUpperCase() + this.substr(1);
};

/**
 *
 * @param options
 */
String.prototype.waiting = function (options) {

    var self = this.toString();

    var timerId = setInterval(function () {

        if (options['parrent'] ? options['parrent'][self] : window[self]) {
            clearInterval(timerId);

            options['done'] && options['done'] instanceof Function && options['done']();
        }

    }, 100);
};

$(function () {

    $('[data-qtip-at]').qtip({

        content: {
            attr: 'title'
        },
        events: {
            
            render: function(event, api) {

                var $target = $(api.target);

                var at = $target.data('qtip-at');
                if (at && at.split(' ').length == 2) {

                    api.set('position.at', at);

                    var my = at.split(' ').map(function (it, num) {

                        var ret;
                        switch (it) {
                            case 'top':
                                ret = 'bottom';
                                break;
                            case 'bottom':
                                ret = 'top';
                                break;
                            case 'right':
                                ret = 'left';
                                break;
                            case 'left':
                                ret = 'right';
                                break;
                            default: ret = it;
                        }

                        return ret;

                    }).join(' ');

                    api.set('position.my', my);
                }

                if ($target.data('qtip-theme')) {

                    api.set('style.classes', 'qtip-' + $target.data('qtip-theme') + ' qtip-shadow');

                } else {

                    api.set('style.classes', 'qtip-light qtip-shadow');
                }
            }
        }
    });
});