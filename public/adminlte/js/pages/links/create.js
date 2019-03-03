$(function () {
    "use strict";
    $('#save_crawl').click(function (e) {
        $('<input>').attr('type','hidden').attr('name','is_crawl').attr('value','1').appendTo('form');
        $("#link-form").submit();
    });
    $('#add_link').click(function (e) {
        let links = $(".fragment");
        var $link = links.last();
        var $linkClone = $link.clone();
        $linkClone.find("input").val( "");
        $linkClone.appendTo( "#list-links");
    });
});
function removeLinks(e) {
    let links = $(".fragment");
    if (links.length >1) {
        e.parentNode.remove();
    }
    resetName();
}