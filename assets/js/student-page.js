/**
 * Created on 22.05.2016.
 */
$(function () {

    var scrollbox = new Scrollbox({
        message: 'Объявлений не найдено',
        limit: 10
    });

    scrollbox.success = function (data) {

        var self = this;

        if (data.error) {

            notification({
                text: 'Ошибка! <br> ' + 'Объявления не найдено',
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

            $(document).on('click', '.cv-send', function () {
                
                var $submitButton = $(this),
                    sendData = {
                        ad_id: $(this).closest('.brick').data('id'),
                        flash: $('[name="flash"]').val()
                    };

                $.ajax({
                    url: '/student/cv/send',
                    dataType: 'json',
                    method: 'POST',
                    data: sendData,
                    beforeSend: function () {
                        $submitButton.prop('disabled', true);
                    },
                    success: function (data) {

                        var notyConf = {
                            text: data['message'],
                            type: data['type'],
                            timeout: 5000
                        };

                        if ('success' === data['type']) {

                            $submitButton.remove();

                            notyConf.animation = {
                                open: 'animated bounceInRight',
                                close: 'animated bounceOutRight'
                            };
                        }

                        notification(notyConf);
                    },
                    error: function (err) {

                        notification({
                            text: 'Ошибка! <br> Отказ сервера',
                            type: 'error'
                        });

                        console.error(err);
                    }
                });
            });
        }
    });
});