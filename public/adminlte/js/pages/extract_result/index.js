$(function () {
    "use strict";
    $('.change_style').on('click','a', function (e) {
        var target = e.target;
        if($(this).hasClass('shop_grid_btn')) {
            $('.shop_block h3').html('Shop Grid');
            $('.shop_block .shop_cnt').removeClass('shop_list');
            $('.shop_block .shop_cnt').addClass('shop_grid');
            $('.change_style a').removeClass('active');
            $(target).parent().addClass('active');
            console.log(target);
            return false;
        } else {
            $('.shop_block h3').html('Shop List');
            $('.shop_block .shop_cnt').removeClass('shop_grid');
            $('.shop_block .shop_cnt').addClass('shop_list');
            $('.change_style a').removeClass('active');
            $(target).parent().addClass('active');
            console.log(target);
            return false;
        }
    });
    // $('#DataTables_Table_0').remove();
});