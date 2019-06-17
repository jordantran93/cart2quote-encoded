define([
    'jquery'
], function ($) {
    'use strict';

    return function (widget) {
        $.widget('mage.SwatchRenderer', widget, {
            options: {
                selectorAddToCart: '[data-role=addToCartButton]',
                selectorAddToQuote: '[data-role=addToQuoteButton]',
                dynamicAddButtons: false
            },
            _init: function () {
                this._super();
                if (typeof this.options.jsonConfig.dynamic_add_buttons !== "undefined") {
                    this.dynamicAddButtons = this.options.jsonConfig.dynamic_add_buttons;
                }

                this._UpdateButtons();
            },
            _OnClick: function ($this, widget, eventName) {
                this._super($this, widget, eventName);
                widget._UpdateButtons();
            },
            _UpdateButtons: function () {
                if (this.dynamicAddButtons) {
                    var widget = this,
                        saleable = widget.options.jsonConfig.is_saleable,
                        quotable = widget.options.jsonConfig.is_quotable,
                        cartButton = widget.element.parents(widget.options.selectorProduct)
                            .find(widget.options.selectorAddToCart),
                        quoteButton = widget.element.parents(widget.options.selectorProduct)
                            .find(widget.options.selectorAddToQuote),
                        selectedProduct = this.getProduct(),
                        showCartButton = false,
                        showQuoteButton = false;

                    if (typeof selectedProduct !== "undefined") {
                        showCartButton = saleable[selectedProduct] == 'undefined' ? false : saleable[selectedProduct];
                        showQuoteButton = quotable[selectedProduct] == 'undefined' ? false : quotable[selectedProduct];
                    }

                    cartButton.toggle(showCartButton);
                    quoteButton.toggle(showQuoteButton);
                }
            },
            //This override is to fix the default selection not being selected,
            // because the gallery is not loaded when called from the file:
            // magento/module-swatches/view/frontend/web/js/configurable-customer-data.js
            _EmulateSelectedByAttributeId: function (selectedAttributes) {
                selectedAttributes = $.isEmptyObject(selectedAttributes) ?
                    this.options.jsonConfig.defaultValues :
                    selectedAttributes;
                var context = this._determineProductData().isInProductView ?
                    this.element.parents('.column.main') :
                    this.element.parents('.product-item-info');
                var gallery = context.find(this.options.mediaGallerySelector).data('gallery');

                if (gallery !== undefined) {
                    this._super(selectedAttributes);
                } else {
                    context.find(this.options.mediaGallerySelector).on('gallery:loaded', function (loadedGallery) {
                        this._EmulateSelectedByAttributeId(selectedAttributes);
                    }.bind(this));
                }
            }
        });

        return $.mage.SwatchRenderer;
    }
});