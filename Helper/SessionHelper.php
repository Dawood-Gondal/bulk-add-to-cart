<?php
/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_BulkAddToCart
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

namespace M2Commerce\BulkAddToCart\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 *  Session Config Helper Class
 */
class SessionHelper extends AbstractHelper
{
    private const PATH_CONFIG_IS_ENABLE = "bulkAddToCart/general/enable";

    public function isBulkAddToCartEnable()
    {
        return (int)$this->scopeConfig->getValue(self::PATH_CONFIG_IS_ENABLE);
    }
}
