/**
 * Created on 22.05.2016.
 */
$(function () {

    var scrollbox = new Scrollbox({
        message: 'Резюме не найдено',
        limit: 10
    });

    scrollbox.success = function (data) {

        var self = this;

        if (data.error) {

            notification({
                text: 'Ошибка! <br> ' + 'Резюме не найдено',
                type: 'error'
            });

        } else {

            if (data.length) {

                data.forEach(function (it) {
                    self.$scrollbox.append(self.render(it));
                });

            } else if (!self.$scrollbox.count) {

                self.$scrollbox.append(self.render({
                    notyfication: 1,
                    type: 'info',
                    message: self.params.message
                }));
            }
        }
    };

    scrollbox.error = function (err) {

        notification({
            text: 'Ошибка! <br> Отказ сервера',
            type: 'error'
        });
    };

    'Handlebars'.waiting({
        done: function () {
            scrollbox.init();
        }
    });
});