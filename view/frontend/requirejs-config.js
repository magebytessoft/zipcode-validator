/**
 * Created By : Magebytes Pvt. Ltd.
 */

var magebytes_zipcodevalidator_enable = !window.magebytes_zipcodevalidator_disabled;

config = {
    config: {
        mixins: {
            'Magento_Catalog/js/catalog-add-to-cart': {
                'Magebytes_ZipCodeValidator/js/catalog-add-to-cart-mixin': magebytes_zipcodevalidator_enable
            },
        }
    }
};