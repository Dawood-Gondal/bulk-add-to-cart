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
        var productQtyArr = [];
        $("input[name='qty']").each(function(){
            if ($(this).val() > 0) {
                var attributes = {}
                $('.swatch-option.selected.'+$(this).attr('product_id')).each(function(){
                    attributes[$(this).closest('.swatch-attribute').attr('data-attribute-id')] = $(this).attr('data-option-id');
                }).toArray();

                productQtyArr.push({
                    'id' : $(this).attr('product_id'),
                    'qty' : $(this).val(),
                    'options' : attributes
                });
            }
        }).toArray();

        if (productQtyArr.length < 1) {
            $("#bulk-cart-error").show().delay(2500).fadeOut();
            return;
        }

        var payload = {};
        payload.productsToAdd = productQtyArr;
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
                productQtyArr = [];
            }
            $('.bulk-add-to-cart').html('Add All Items to Cart');
        });
    });
});
