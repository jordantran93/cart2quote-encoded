<?php
/**
 *  CART2QUOTE CONFIDENTIAL
 *  __________________
 *  [2009] - [2018] Cart2Quote B.V.
 *  All Rights Reserved.
 *  NOTICE OF LICENSE
 *  All information contained herein is, and remains
 *  the property of Cart2Quote B.V. and its suppliers,
 *  if any.  The intellectual and technical concepts contained
 *  herein are proprietary to Cart2Quote B.V.
 *  and its suppliers and may be covered by European and Foreign Patents,
 *  patents in process, and are protected by trade secret or copyright law.
 *  Dissemination of this information or reproduction of this material
 *  is strictly forbidden unless prior written permission is obtained
 *  from Cart2Quote B.V.
 * @category    Cart2Quote
 * @package     Quotation
 * @copyright   Copyright (c) 2018. Cart2Quote B.V. (https://www.cart2quote.com)
 * @license     https://www.cart2quote.com/ordering-licenses(https://www.cart2quote.com)
 */

namespace Cart2Quote\Quotation\Escaper;

/**
 * Class Escaper
 * @package Cart2Quote\Quotation\Escaper
 */
class Escaper extends \Magento\Framework\Escaper
{

    /**
     * Escape string for the JavaScript context
     *
     * @param string $string
     * @return string
     */
    public function escapeJs($string)
    {
        /**
         * \Magento\Framework\Escaper implements the methond escapeJs from 2.2.x
         */
        if (method_exists($this, __FUNCTION__) && !is_subclass_of($this, \Zend\Escaper\Escaper::class)) {
            return parent::escapeJs($string);
        }

        /**
         * \Magento\Framework\EscapeHelper implements the methond escapeJs from 2.0.x to 2.1.x
         */
        if (class_exists(\Magento\Framework\EscapeHelper::class)) {
            /**
             * @var \Magento\Framework\EscapeHelper $escaper
             */
            $escaper = \Magento\Framework\App\ObjectManager::getInstance()->get(\Magento\Framework\EscapeHelper::class);
            if (method_exists($escaper, __FUNCTION__)) {
                return $escaper->escapeJs($string);
            }
        }

        //Fallback
        if ($string === '' || ctype_digit($string)) {
            return $string;
        }

        return preg_replace_callback(
            '/[^a-z0-9,\._]/iSu',
            function ($matches) {
                $chr = $matches[0];
                if (strlen($chr) != 1) {
                    $chr = mb_convert_encoding($chr, 'UTF-16BE', 'UTF-8');
                    $chr = ($chr === false) ? '' : $chr;
                }

                return sprintf('\\u%04s', strtoupper(bin2hex($chr)));
            },
            $string
        );
    }
}
