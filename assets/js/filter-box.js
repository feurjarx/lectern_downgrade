/**
 * Created on 31.05.2016.
 */

$(function () {

    $('.selectpicker-filter').on('changed.bs.select', function () {

        var scrollbox = $('.scrollbox').data('scrollbox');
        scrollbox.params.filters[$(this).attr('name')] = $(this).val();
        scrollbox.refresh();
    })
});