$(function () {
    "use strict";
    $('#save_crawl').click(function (e) {
        $('<input>').attr('type','hidden').attr('name','is_crawl').attr('value','1').appendTo('form');
        $("#link-form").submit();
    });
    $('#add_link').click(function (e) {
        alert("aaa");
    });
});