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

        ajaxSubmit: function(form) 
        {
            var self = this;
            $(self.options.minicartSelector).trigger('contentLoading');
            self.disableAddToCartButton(form);
            self.enableAddToCartButton(form);

            $.ajax({
                url: form.attr('action'),
                data: form.serialize(),
                type: 'post',
                dataType: 'json',
                beforeSend: function() 
                {
                    if (self.isLoaderEnabled()) 
                    {
                        $('body').trigger(self.options.processStart);
                    }
                },
            });
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
