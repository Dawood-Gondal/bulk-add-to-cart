/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_BulkAddToCart
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

define([
    'jquery',
    'mage/url'
], function ($, url) {
    'use strict';

    $( "#add-all-to-cart-button" ).click(function() {
        var productQtyarr = [];
        $("input[id='qty']").each(function(){
            if ($(this).val() > 0) {
                productQtyarr.push({'id':$(this).attr('product_id'), 'qty':$(this).val()});
            }
        }).toArray();

        if (productQtyarr.length < 1) {
            $("#bulk-cart-error").show().delay(2500).fadeOut();
            return;
        }

        var payload = {};
        payload.productsToAdd = productQtyarr;
        var actionUrl = url.build('bulkAddToCart/ajaxcart/add');

        $.ajax({
            url: actionUrl,
            data: payload,
            method: 'POST',
            cache: false,
            beforeSend: function(){
                $('.bulk-add-to-cart').html('Adding...');
            }
        }).done(function(response){
            if (response.status) {
                $('.bulk-add-to-cart').html('Added!');
                $('input[name="qty"]').val(0);
                productQtyarr = [];
            }
            $('.bulk-add-to-cart').html('Add All Items to Cart');
        });
    });
});
