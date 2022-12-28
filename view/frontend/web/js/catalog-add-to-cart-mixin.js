/**
 * Created By : Magebytes Pvt. Ltd.
 */
define([
    'jquery',
    'mage/translate',
    'jquery/ui',
    'Magento_Catalog/js/catalog-add-to-cart'
], function ($, $t) {
    'use strict';

    $.widget('mage.catalogAddToCart', {
        options: {
            addToCartButtonDisabledClass: 'disabled'
        },

        /**
         * @param {String} form
         */
        disableAddToCartButton: function (form) {
            setTimeout(function () {
                addToCartButton.addClass(self.options.addToCartButtonDisabledClass);
            }, 1000);
        }
    });

    return $.mage.catalogAddToCart;
});
